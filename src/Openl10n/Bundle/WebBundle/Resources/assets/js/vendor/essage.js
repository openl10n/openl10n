/* Essage - a more elegant way to show message
 * https://github.com/sofish/essage
 */
~function(win, doc) {

  var Utils = {

    is: function(obj, type) {
      return Object.prototype.toString.call(obj).slice(8, -1) === type;
    },

    copy: function(defaults, source) {
      for(var p in source) {
        if(source.hasOwnProperty(p)) {
          var val = source[p];
          defaults[p] = this.is(val, 'Object') ? this.copy({}, val) :
            this.is(val, 'Array') ? this.copy([], val) : val;
        }
      }
      return defaults;
    }
  }

  var Essage = function() {
    var self = this;

    this.defaults = {
      placement: 'top',
      status: 'normal'
    }

    this.el = doc.createElement('div');
    this.el.className = 'essage';

    this.close = '<span class="close">&times;</span>';

    this.el.onclick = function(e) {
      var e = e || win.event
        , target = e.target || e.srcElement;
      if(target.className === 'close') self.hide();
    }

    // placement of the message, by default is `top`
    this.placement = 'top';

    doc.body.appendChild(this.el);
    this.el.top = -this._height();

    return this;
  };

  Essage.prototype._height = function() {
    return this.el.offsetHeight || this.el.clientHeight;
  };

  Essage.prototype._class = function(classname, isRemove) {
    var el = this.el;

    if(el.classList) {
      el.classList[isRemove ? 'remove' : 'add'](classname);
    } else {
      var defaultclass= el.className
        , reg = new RegExp('\\b' + classname + '\\b', 'g');

      el.className = isRemove ? defaultclass.replace(reg, '') :
        defaultclass.match(reg) ? defaultclass : (defaultclass + ' ' + classname);
    }

    return el;
  };

  Essage.prototype.set = function(message) {

    message = typeof message === 'string' ? { message: message } : message;

    // copy for each message
    this.config = Utils.copy({}, this.defaults);
    this.config = Utils.copy(this.config, message);

    // placement check
    !this.config.placement.match(/^(?:top|bottom)$/) && (this.config.placement = 'top');

    // adjust placement
    this.el.style[this.config.placement === 'top' ? 'bottom' : 'top'] = 'auto';

    // set status(className)
    this.el.className = 'essage';
    this._class('essage-' + this.config.status);

    return this;
  };

  Essage.prototype.show = function(message, duration) {
    var el = this.el
      , self = this.set(message)
      , interval, timeout;

    // set message
    el.innerHTML = this.close + this.config.message;

    var top = -this._height();

    // disppear automaticlly
    if(this._timeout) clearTimeout(this._timeout);
    duration && (timeout = function() {
      return setTimeout(function() {
        self.hide();
      }, duration);
    });

    interval = setInterval(function() {
      if(top === 0) {
        self._timeout = timeout && timeout();
        return clearInterval(interval);
      }
      el.style[self.config.placement] = (top += 1) + 'px';
    }, 3);

    return this;
  };

  Essage.prototype.hide = function() {
    var top = +this.el.style[this.config.placement].slice(0, -2)
      , dest = -this._height()
      , self = this
      , interval;

    interval = setInterval(function() {
      if(top === dest) return interval && clearInterval(interval);
      self.el.style[self.config.placement] = (top -= 1) + 'px';
    }, 3);
    return this;
  }

  // export to window
  win.Essage = new Essage();

}(window, document);
