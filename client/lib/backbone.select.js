// Backbone.Select, v1.2.6
// Copyright (c) 2014 Michael Heim
//           (c) 2013 Derick Bailey, Muted Solutions, LLC.
// Distributed under MIT license
// http://github.com/hashchange/backbone.select

;( function ( Backbone, _ ) {
    var Select = {};

    // Select.One
    // ------------------
    // A single-select mixin for Backbone.Collection, allowing a single
    // model to be selected within a collection. Selection of another
    // model within the collection causes the previous model to be
    // deselected.

    Select.One = function () {};

    _.extend( Select.One.prototype, {

        // Type indicator, undocumented, but part of the API (monitored by tests).
        // Can be queried safely by other components. Use it read-only.
        _pickyType: "Backbone.Select.One",

        // Select a model, deselecting any previously selected model
        select: function ( model, options ) {
            var reselected = model && this.selected === model ? model : undefined;

            options = initOptions( options );
            if ( options._processedBy[this._pickyCid] ) return;

            if ( !reselected ) {
                this.deselect( undefined, _.extend(
                    // _eventQueue vs _eventQueueAppendOnly:
                    //
                    // When a deselect sub action is initiated from a select action, the
                    // deselection events are added to the common event queue. But the
                    // event queue must not be resolved prematurely during the
                    // deselection phase. Resolution is prevented by naming the queue
                    // differently.
                    _.omit( options, "_silentLocally", "_processedBy", "_eventQueue" ),
                    { _eventQueueAppendOnly: options._eventQueue }
                ) );
                this.selected = model;
            }
            options._processedBy[this._pickyCid] = { done: false };

            if ( !options._processedBy[this.selected.cid] ) this.selected.select( stripLocalOptions( options ) );

            if ( !(options.silent || options._silentLocally) ) {

                if ( reselected ) {
                    if ( !options._silentReselect ) queueEvent( options, this, [ "reselect:one", model, this, stripInternalOptions( options ) ] );
                } else {
                    queueEvent( options, this, [ "select:one", model, this, stripInternalOptions( options ) ] );
                }

            }

            options._processedBy[this._pickyCid].done = true;
            processEventQueue( options );
        },

        // Deselect a model, resulting in no model
        // being selected
        deselect: function ( model, options ) {
            options = initOptions( options );
            if ( options._processedBy[this._pickyCid] ) return;

            if ( !this.selected ) return;

            model = model || this.selected;
            if ( this.selected !== model ) return;

            options._processedBy[this._pickyCid] = { done: false };

            delete this.selected;
            if ( !options._skipModelCall ) model.deselect( stripLocalOptions( options ) );
            if ( !(options.silent || options._silentLocally) ) queueEvent( options, this, [ "deselect:one", model, this, stripInternalOptions( options ) ] );

            options._processedBy[this._pickyCid].done = true;
            processEventQueue( options );
        },

        close: function () {
            unregisterCollectionWithModels( this );
            this.stopListening();
        }

    } );

    // Select.Many
    // -----------------
    // A multi-select mixin for Backbone.Collection, allowing a collection to
    // have multiple items selected, including `selectAll` and `deselectAll`
    // capabilities.

    Select.Many = function () {};

    _.extend( Select.Many.prototype, {

        // Type indicator, undocumented, but part of the API (monitored by tests).
        // Can be queried safely by other components. Use it read-only.
        _pickyType: "Backbone.Select.Many",

        // Select a specified model, make sure the model knows it's selected, and
        // hold on to the selected model.
        select: function ( model, options ) {
            var prevSelected = multiSelectionToArray( this.selected ),
                reselected = this.selected[model.cid] ? [ model ] : [];

            options = initOptions( options );

            if ( reselected.length && options._processedBy[this._pickyCid] ) return;

            if ( !reselected.length ) {
                this.selected[model.cid] = model;
                this.selectedLength = _.size( this.selected );
            }
            options._processedBy[this._pickyCid] = { done: false };

            if ( !options._processedBy[model.cid] ) model.select( stripLocalOptions( options ) );
            triggerMultiSelectEvents( this, prevSelected, options, reselected );

            options._processedBy[this._pickyCid].done = true;
            processEventQueue( options );
        },

        // Deselect a specified model, make sure the model knows it has been deselected,
        // and remove the model from the selected list.
        deselect: function ( model, options ) {
            var prevSelected = multiSelectionToArray( this.selected );

            options = initOptions( options );
            if ( options._processedBy[this._pickyCid] ) return;

            if ( !this.selected[model.cid] ) return;

            options._processedBy[this._pickyCid] = { done: false };

            delete this.selected[model.cid];
            this.selectedLength = _.size( this.selected );

            if ( !options._skipModelCall ) model.deselect( stripLocalOptions( options ) );
            triggerMultiSelectEvents( this, prevSelected, options );

            options._processedBy[this._pickyCid].done = true;
            processEventQueue( options );
        },

        // Select all models in this collection
        selectAll: function ( options ) {
            var prevSelected = multiSelectionToArray( this.selected ),
                reselected = [];

            options || (options = {});

            this.selectedLength = 0;
            this.each( function ( model ) {
                this.selectedLength++;
                if ( this.selected[model.cid] ) reselected.push( model );
                this.select( model, _.extend( {}, options, {_silentLocally: true} ) );
            }, this );

            options = initOptions( options );
            triggerMultiSelectEvents( this, prevSelected, options, reselected );

            if ( options._processedBy[this._pickyCid] ) {
                options._processedBy[this._pickyCid].done = true;
            } else {
                options._processedBy[this._pickyCid] = { done: true };
            }
            processEventQueue( options );
        },

        // Deselect all models in this collection
        deselectAll: function ( options ) {
            var prevSelected;

            if ( this.selectedLength === 0 ) return;
            prevSelected = multiSelectionToArray( this.selected );

            options || (options = {});

            this.each( function ( model ) {
                if ( model.selected ) this.selectedLength--;
                this.deselect( model, _.extend( {}, options, {_silentLocally: true} ) );
            }, this );

            this.selectedLength = 0;

            options = initOptions( options );
            triggerMultiSelectEvents( this, prevSelected, options );

            if ( options._processedBy[this._pickyCid] ) {
                options._processedBy[this._pickyCid].done = true;
            } else {
                options._processedBy[this._pickyCid] = { done: true };
            }
            processEventQueue( options );
        },

        selectNone: function ( options ) {
            this.deselectAll( options );
        },

        // Toggle select all / none. If some are selected, it will select all. If all
        // are selected, it will select none. If none are selected, it will select all.
        toggleSelectAll: function ( options ) {
            if ( this.selectedLength === this.length ) {
                this.deselectAll( options );
            } else {
                this.selectAll( options );
            }
        },

        close: function () {
            unregisterCollectionWithModels( this );
            this.stopListening();
        }
    } );

    // Select.Me
    // ----------------
    // A selectable mixin for Backbone.Model, allowing a model to be selected,
    // enabling it to work with Select.One or Select.Many, or on it's own.

    Select.Me = function () {};

    _.extend( Select.Me.prototype, {

        // Type indicator, undocumented, but part of the API (monitored by tests).
        // Can be queried safely by other components. Use it read-only.
        _pickyType: "Backbone.Select.Me",

        // Select this model, and tell our
        // collection that we're selected
        select: function ( options ) {
            var reselected = this.selected;

            options = initOptions( options );
            if ( options._processedBy[this.cid] ) return;

            options._processedBy[this.cid] = { done: false };
            this.selected = true;

            if ( this._pickyCollections ) {
                // Model-sharing mode: notify collections with an event
                this.trigger( "_selected", this, stripLocalOptions( options ) );
            } else if ( this.collection ) {
                // Single collection only: no event listeners set up in collection, call
                // it directly
                if ( !options._processedBy[this.collection._pickyCid] ) this.collection.select( this, stripLocalOptions( options ) );
            }

            if ( !(options.silent || options._silentLocally) ) {
                if ( reselected ) {
                    if ( !options._silentReselect ) queueEvent( options, this, [ "reselected", this, stripInternalOptions( options ) ] );
                } else {
                    queueEvent( options, this, [ "selected", this, stripInternalOptions( options ) ] );
                }
            }

            options._processedBy[this.cid].done = true;
            processEventQueue( options );
        },

        // Deselect this model, and tell our collection that we're deselected
        deselect: function ( options ) {
            options = initOptions( options );
            if ( options._processedBy[this.cid] ) return;

            if ( !this.selected ) return;

            options._processedBy[this.cid] = { done: false };
            this.selected = false;

            if ( this._pickyCollections ) {
                // Model-sharing mode: notify collections with an event
                this.trigger( "_deselected", this, stripLocalOptions( options ) );
            } else if ( this.collection ) {
                // Single collection only: no event listeners set up in collection, call
                // it directly
                this.collection.deselect( this, stripLocalOptions( options ) );
            }

            if ( !(options.silent || options._silentLocally) ) queueEvent( options, this, [ "deselected", this, stripInternalOptions( options ) ] );

            options._processedBy[this.cid].done = true;
            processEventQueue( options );
        },

        // Change selected to the opposite of what
        // it currently is
        toggleSelected: function ( options ) {
            if ( this.selected ) {
                this.deselect( options );
            } else {
                this.select( options );
            }
        }
    } );

    // Applying the mixin: class methods for setup
    Select.Me.applyTo = function ( hostObject ) {
        if ( !_.isObject( hostObject ) ) throw new Error( "The host object is undefined or not an object." );

        _.extend( hostObject, new Backbone.Select.Me() );
        augmentTrigger( hostObject );
    };

    Select.One.applyTo = function ( hostObject, models, options ) {
        var oldSelect;

        if ( !_.isObject( hostObject ) ) throw new Error( "The host object is undefined or not an object." );
        if ( arguments.length < 2 ) throw new Error( "The `models` parameter has not been passed to Select.One.applyTo. Its value can be undefined if no models are passed in during instantiation, but even so, it must be provided." );
        if ( !(_.isArray( models ) || _.isUndefined( models ) || _.isNull( models )) ) throw new Error( "The `models` parameter is not of the correct type. It must be either an array of models, or be undefined. (Null is acceptable, too)." );

        // Store a reference to the existing select method (most likely the
        // default Backbone.Collection.select method). Used to overload the new
        // select method.
        oldSelect = hostObject.select;

        _.extend( hostObject, new Backbone.Select.One() );

        hostObject._pickyCid = _.uniqueId( 'singleSelect' );
        augmentTrigger( hostObject );
        overloadSelect( oldSelect, hostObject );

        if ( options && options.enableModelSharing ) {

            // model-sharing mode
            _.each( models || [], function ( model ) {
                registerCollectionWithModel( model, hostObject );
                if ( model.selected ) {
                    if ( hostObject.selected ) hostObject.selected.deselect();
                    hostObject.selected = model;
                }
            } );

            hostObject.listenTo( hostObject, '_selected', hostObject.select );
            hostObject.listenTo( hostObject, '_deselected', hostObject.deselect );

            hostObject.listenTo( hostObject, 'reset', onResetSingleSelect );
            hostObject.listenTo( hostObject, 'add', onAdd );
            hostObject.listenTo( hostObject, 'remove', onRemove );

            // Mode flag, undocumented, but part of the API (monitored by tests). Can
            // be queried safely by other components. Use it read-only.
            hostObject._modelSharingEnabled = true;

        }

    };

    Select.Many.applyTo = function ( hostObject, models, options ) {
        var oldSelect;

        if ( !_.isObject( hostObject ) ) throw new Error( "The host object is undefined or not an object." );
        if ( arguments.length < 2 ) throw new Error( "The `models` parameter has not been passed to Select.One.applyTo. Its value can be undefined if no models are passed in during instantiation, but even so, it must be provided." );
        if ( !(_.isArray( models ) || _.isUndefined( models ) || _.isNull( models )) ) throw new Error( "The `models` parameter is not of the correct type. It must be either an array of models, or be undefined. (Null is acceptable, too)." );

        // Store a reference to the existing select method (most likely the
        // default Backbone.Collection.select method). Used to overload the new
        // select method.
        oldSelect = hostObject.select;

        _.extend( hostObject, new Backbone.Select.Many() );

        hostObject._pickyCid = _.uniqueId( 'multiSelect' );
        hostObject.selected = {};
        augmentTrigger( hostObject );
        overloadSelect( oldSelect, hostObject );

        if ( options && options.enableModelSharing ) {

            // model-sharing mode
            _.each( models || [], function ( model ) {
                registerCollectionWithModel( model, hostObject );
                if ( model.selected ) hostObject.selected[model.cid] = model;
            } );

            hostObject.listenTo( hostObject, '_selected', hostObject.select );
            hostObject.listenTo( hostObject, '_deselected', hostObject.deselect );

            hostObject.listenTo( hostObject, 'reset', onResetMultiSelect );
            hostObject.listenTo( hostObject, 'add', onAdd );
            hostObject.listenTo( hostObject, 'remove', onRemove );

            // Mode flag, undocumented, but part of the API (monitored by tests). Can
            // be queried safely by other components. Use it read-only.
            hostObject._modelSharingEnabled = true;

        }

    };

    // Helper Methods
    // --------------

    // Trigger events from a multi-select collection, based on the number of selected items.
    var triggerMultiSelectEvents = function ( collection, prevSelected, options, reselected ) {
        function mapCidsToModels ( cids, collection, previousSelection ) {
            function mapper ( cid ) {
                // Find the model in the collection. If not found, it has been removed,
                // so get it from the array of previously selected models.
                return collection.get( cid ) || previousSelection[cid];
            }

            return _.map( cids, mapper );
        }

        if ( options.silent || options._silentLocally ) return;

        var selectedLength = collection.selectedLength,
            length = collection.length,
            prevSelectedCids = _.keys( prevSelected ),
            selectedCids = _.keys( collection.selected ),
            addedCids = _.difference( selectedCids, prevSelectedCids ),
            removedCids = _.difference( prevSelectedCids, selectedCids ),
            unchanged = (selectedLength === prevSelectedCids.length && addedCids.length === 0 && removedCids.length === 0),
            diff;

        if ( reselected && reselected.length && !options._silentReselect ) {
            queueEvent( options, collection, [ "reselect:any", reselected, collection, stripInternalOptions( options ) ] );
        }

        if ( unchanged ) return;

        diff = {
            selected: mapCidsToModels( addedCids, collection, prevSelected ),
            deselected: mapCidsToModels( removedCids, collection, prevSelected )
        };

        if ( selectedLength === length ) {
            queueEvent( options, collection, [ "select:all", diff, collection, stripInternalOptions( options ) ] );
            return;
        }

        if ( selectedLength === 0 ) {
            queueEvent( options, collection, [ "select:none", diff, collection, stripInternalOptions( options ) ] );
            return;
        }

        if ( selectedLength > 0 && selectedLength < length ) {
            queueEvent( options, collection, [ "select:some", diff, collection, stripInternalOptions( options ) ] );
            return;
        }
    };

    function onAdd ( model, collection ) {
        registerCollectionWithModel( model, collection );
        if ( model.selected ) collection.select( model, {_silentReselect: true, _externalEvent: "add"} );
    }

    function onRemove ( model, collection, options ) {
        releaseModel( model, collection, _.extend( {}, options, {_externalEvent: "remove"} ) );
    }

    function releaseModel ( model, collection, options ) {
        if ( model._pickyCollections ) model._pickyCollections = _.without( model._pickyCollections, collection._pickyCid );
        if ( model.selected ) {
            if ( model._pickyCollections && model._pickyCollections.length === 0 ) {
                collection.deselect( model, options );
            } else {
                collection.deselect( model, _.extend( {}, options, {_skipModelCall: true} ) );
            }
        }
    }

    function onResetSingleSelect ( collection, options ) {
        var selected,
            excessiveSelections,
            deselectOnRemove = _.find( options.previousModels, function ( model ) { return model.selected; } );

        if ( deselectOnRemove ) releaseModel( deselectOnRemove, collection, {_silentLocally: true} );
        _.each( options.previousModels, function ( model ) {
            if ( model._pickyCollections ) model._pickyCollections = _.without( model._pickyCollections, collection._pickyCid );
        } );

        collection.each( function ( model ) {
            registerCollectionWithModel( model, collection );
        } );
        selected = collection.filter( function ( model ) { return model.selected; } );
        excessiveSelections = _.initial( selected );
        if ( excessiveSelections.length ) _.each( excessiveSelections, function ( model ) { model.deselect(); } );
        if ( selected.length ) collection.select( _.last( selected ), {silent: true} );
    }

    function onResetMultiSelect ( collection, options ) {
        var select,
            deselect = _.filter( options.previousModels, function ( model ) { return model.selected; } );

        if ( deselect ) _.each( deselect, function ( model ) { releaseModel( model, collection, {_silentLocally: true} ); } );

        _.each( options.previousModels, function ( model ) {
            if ( model._pickyCollections ) model._pickyCollections = _.without( model._pickyCollections, collection._pickyCid );
        } );

        collection.each( function ( model ) {
            registerCollectionWithModel( model, collection );
        } );
        select = collection.filter( function ( model ) { return model.selected; } );
        if ( select.length ) _.each( select, function ( model ) { collection.select( model, {silent: true} ); } );
    }

    function registerCollectionWithModel ( model, collection ) {
        model._pickyCollections || (model._pickyCollections = []);
        model._pickyCollections.push( collection._pickyCid );
    }

    function unregisterCollectionWithModels ( collection ) {
        collection.each( function ( model ) {
            releaseModel( model, collection, {_silentLocally: true} );
        } );
    }

    function stripLocalOptions ( options ) {
        return _.omit( options, "_silentLocally", "_externalEvent" );
    }

    function stripInternalOptions ( options ) {
        return _.omit( options, "_silentLocally", "_silentReselect", "_skipModelCall", "_processedBy", "_eventQueue", "_eventQueueAppendOnly" );
    }

    function multiSelectionToArray ( selectionsHash ) {
        function mapper ( value, key ) {
            selectedArr[key] = value;
        }

        var selectedArr = [];
        _.each( selectionsHash, mapper );

        return selectedArr;
    }

    function initOptions ( options ) {
        options || (options = {});
        options._processedBy || (options._processedBy = {});
        options._eventQueue || (options._eventQueue = []);

        return options;
    }

    function queueEvent ( storage, actor, triggerArgs ) {
        // Use either _eventQueue, which will eventually be processed by the calling
        // object, or _eventQueueAppendOnly, which is another object's event queue
        // and resolved elsewhere. _eventQueueAppendOnly exists only when needed,
        // and thus takes precedence.
        var queue = storage._eventQueueAppendOnly || storage._eventQueue;
        queue.push( {
            actor: actor,
            triggerArgs: triggerArgs
        } );
    }

    function processEventQueue ( storage ) {
        var resolved, eventData;

        if ( storage._eventQueue.length ) {
            resolved = _.every( storage._processedBy, function ( entry ) {
                return entry.done;
            } );

            if ( resolved ) {
                mergeMultiSelectEvents( storage._eventQueue );
                while ( storage._eventQueue.length ) {
                    eventData = storage._eventQueue.pop();
                    eventData.actor.trigger.apply( eventData.actor, eventData.triggerArgs );
                }
            }
        }
    }

    // Merges separate (sub-)events of a Select.Many collection into a single,
    // summary event, and cleans up the event queue.
    //
    // NB "reselect:any" events stand on their own and are not merged into a joint
    // select:some event. They only occur once per collection in the event queue.
    function mergeMultiSelectEvents ( queue ) {
        var multiSelectCollections = {};

        // Create merged data for each multi-select collection
        _.each( queue, function ( event, index ) {
            var extractedData, diff, opts,
                actor = event.actor,
                eventName = event.triggerArgs[0];

            if ( actor._pickyType === "Backbone.Select.Many" && eventName !== "reselect:any" ) {

                extractedData = multiSelectCollections[actor._pickyCid];
                if ( !extractedData ) extractedData = multiSelectCollections[actor._pickyCid] = {
                    actor: actor,
                    indexes: [],
                    merged: {
                        selected: [],
                        deselected: [],
                        options: {}
                    }
                };

                extractedData.indexes.push( index );

                diff = event.triggerArgs[1];
                opts = event.triggerArgs[3];
                extractedData.merged.selected = extractedData.merged.selected.concat( diff.selected );
                extractedData.merged.deselected = extractedData.merged.deselected.concat( diff.deselected );
                _.extend( extractedData.merged.options, opts );

            }
        } );

        // If there are multiple event entries for a collection, remove them from
        // the queue and append a merged event.

        // - Don't touch the queued events for multi-select collections which have
        //   just one entry.
        multiSelectCollections = _.filter( multiSelectCollections, function ( entry ) {
            return entry.indexes.length > 1;
        } );

        // - Remove existing entries in the queue.
        var removeIndexes = _.flatten( _.pluck( multiSelectCollections, "indexes" ) );
        removeIndexes.sort( function ( a, b ) {
            return a - b;
        } );
        _.each( removeIndexes, function ( position, index ) {
            queue.splice( position - index, 1 );
        } );

        // - Append merged event entry.
        _.each( multiSelectCollections, function ( extractedData ) {

            // NB Multiple entries only occur if a select has been accompanied by
            // one or more deselects. By definition, that translates into a
            // select:some event (and never into select:all, select:none).
            queue.push( {
                actor: extractedData.actor,
                triggerArgs: [
                    "select:some",
                    { selected: extractedData.merged.selected, deselected: extractedData.merged.deselected },
                    extractedData.actor,
                    extractedData.merged.options
                ]
            } );

        } );

    }

    // Overloads the select method. Provides access to the previous, legacy
    // implementation, based on the arguments passed to the method.
    //
    // If `select` is called with a model as first parameter, the `select`
    // method of the mixin is used, otherwise the previous implementation is
    // called.
    function overloadSelect( oldSelect, context ) {

        context.select = (function () {
            var mixinSelect = context.select;
            return function ( model ) {
                if ( model instanceof Backbone.Model ) {
                    return mixinSelect.apply( context, arguments );
                } else {
                    return oldSelect.apply( context, arguments );
                }
            };
        })();

    }

    // Creates a new trigger method which calls the predefined event handlers
    // (onDeselect etc) as well as triggering the event.
    //
    // Adapted from Marionette.triggerMethod.
    function augmentTrigger ( context ) {

        context.trigger = (function () {

            var origTrigger = context.trigger;

            // Return an augmented trigger method implementation, in order to replace
            // the original trigger method
            return function ( event, eventArgs ) {

                if ( isSelectionEvent( event ) ) {
                    // get the method name from the event name
                    var unifiedEvent = unifyEventNames( event ),

                    // Split the event name on the ":" (regex), capitalize, add "on" prefix
                        methodName = 'on' + unifiedEvent.replace( /(^|:)(\w)/gi, getEventName ),
                        method = this[methodName];

                    // call the onMethodName if it exists
                    if ( _.isFunction( method ) ) {
                        // pass all trigger arguments, except the event name
                        method.apply( this, _.tail( arguments ) );
                    }
                }

                // trigger the event
                origTrigger.apply( this, arguments );
                return this;

            };

        })();
    }

    // Helpers for augmentTrigger

    // Checks if the event is generated by Backbone.Select. Excludes internal
    // events like `_selected`.
    function isSelectionEvent ( eventName ) {
        return ( /^([rd]e)?select(ed)?($|:)/ ).test( eventName );
    }

    // Take the event section ("section1:section2:section3") and turn it
    // into an uppercase name
    //noinspection JSUnusedLocalSymbols
    function getEventName ( match, prefix, eventName ) {
        return eventName.toUpperCase();
    }

    // Unifies event names for the method call:
    // - (re, de)selected   => (re, de)select
    // - (re, de)select:one => (re, de)select
    // - reselect:any       => reselect
    function unifyEventNames ( eventName ) {
        if ( eventName.slice( -2 ) === "ed" ) {
            eventName = eventName.slice( 0, -2 );
        } else if ( eventName.slice( -4 ) === ":one" || eventName.slice( -4 ) === ":any" ) {
            eventName = eventName.slice( 0, -4 );
        }

        return eventName;
    }

    Backbone.Select = Select;

} )( Backbone, _ );
