/* ===================================================
 * bootstrap-transition.js v2.0.4
 * http://twitter.github.com/bootstrap/javascript.html#transitions
 * ===================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */


!function (jq18) {

  jq18(function () {

    "use strict"; // jshint ;_;


    /* CSS TRANSITION SUPPORT (http://www.modernizr.com/)
     * ======================================================= */

    jq18.support.transition = (function () {

      var transitionEnd = (function () {

        var el = document.createElement('bootstrap')
          , transEndEventNames = {
               'WebkitTransition' : 'webkitTransitionEnd'
            ,  'MozTransition'    : 'transitionend'
            ,  'OTransition'      : 'oTransitionEnd'
            ,  'msTransition'     : 'MSTransitionEnd'
            ,  'transition'       : 'transitionend'
            }
          , name

        for (name in transEndEventNames){
          if (el.style[name] !== undefined) {
            return transEndEventNames[name]
          }
        }

      }())

      return transitionEnd && {
        end: transitionEnd
      }

    })()

  })

}(window.jQuery);/* ==========================================================
 * bootstrap-alert.js v2.0.4
 * http://twitter.github.com/bootstrap/javascript.html#alerts
 * ==========================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */


!function (jq18) {

  "use strict"; // jshint ;_;


 /* ALERT CLASS DEFINITION
  * ====================== */

  var dismiss = '[data-dismiss="alert"]'
    , Alert = function (el) {
        jq18(el).on('click', dismiss, this.close)
      }

  Alert.prototype.close = function (e) {
    var jq18this = jq18(this)
      , selector = jq18this.attr('data-target')
      , jq18parent

    if (!selector) {
      selector = jq18this.attr('href')
      selector = selector && selector.replace(/.*(?=#[^\s]*jq18)/, '') //strip for ie7
    }

    jq18parent = jq18(selector)

    e && e.preventDefault()

    jq18parent.length || (jq18parent = jq18this.hasClass('alert') ? jq18this : jq18this.parent())

    jq18parent.trigger(e = jq18.Event('close'))

    if (e.isDefaultPrevented()) return

    jq18parent.removeClass('in')

    function removeElement() {
      jq18parent
        .trigger('closed')
        .remove()
    }

    jq18.support.transition && jq18parent.hasClass('fade') ?
      jq18parent.on(jq18.support.transition.end, removeElement) :
      removeElement()
  }


 /* ALERT PLUGIN DEFINITION
  * ======================= */

  jq18.fn.alert = function (option) {
    return this.each(function () {
      var jq18this = jq18(this)
        , data = jq18this.data('alert')
      if (!data) jq18this.data('alert', (data = new Alert(this)))
      if (typeof option == 'string') data[option].call(jq18this)
    })
  }

  jq18.fn.alert.Constructor = Alert


 /* ALERT DATA-API
  * ============== */

  jq18(function () {
    jq18('body').on('click.alert.data-api', dismiss, Alert.prototype.close)
  })

}(window.jQuery);/* ============================================================
 * bootstrap-button.js v2.0.4
 * http://twitter.github.com/bootstrap/javascript.html#buttons
 * ============================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */


!function (jq18) {

  "use strict"; // jshint ;_;


 /* BUTTON PUBLIC CLASS DEFINITION
  * ============================== */

  var Button = function (element, options) {
    this.jq18element = jq18(element)
    this.options = jq18.extend({}, jq18.fn.button.defaults, options)
  }

  Button.prototype.setState = function (state) {
    var d = 'disabled'
      , jq18el = this.jq18element
      , data = jq18el.data()
      , val = jq18el.is('input') ? 'val' : 'html'

    state = state + 'Text'
    data.resetText || jq18el.data('resetText', jq18el[val]())

    jq18el[val](data[state] || this.options[state])

    // push to event loop to allow forms to submit
    setTimeout(function () {
      state == 'loadingText' ?
        jq18el.addClass(d).attr(d, d) :
        jq18el.removeClass(d).removeAttr(d)
    }, 0)
  }

  Button.prototype.toggle = function () {
    var jq18parent = this.jq18element.parent('[data-toggle="buttons-radio"]')

    jq18parent && jq18parent
      .find('.active')
      .removeClass('active')

    this.jq18element.toggleClass('active')
  }


 /* BUTTON PLUGIN DEFINITION
  * ======================== */

  jq18.fn.button = function (option) {
    return this.each(function () {
      var jq18this = jq18(this)
        , data = jq18this.data('button')
        , options = typeof option == 'object' && option
      if (!data) jq18this.data('button', (data = new Button(this, options)))
      if (option == 'toggle') data.toggle()
      else if (option) data.setState(option)
    })
  }

  jq18.fn.button.defaults = {
    loadingText: 'loading...'
  }

  jq18.fn.button.Constructor = Button


 /* BUTTON DATA-API
  * =============== */

  jq18(function () {
    jq18('body').on('click.button.data-api', '[data-toggle^=button]', function ( e ) {
      var jq18btn = jq18(e.target)
      if (!jq18btn.hasClass('btn')) jq18btn = jq18btn.closest('.btn')
      jq18btn.button('toggle')
    })
  })

}(window.jQuery);/* ==========================================================
 * bootstrap-carousel.js v2.0.4
 * http://twitter.github.com/bootstrap/javascript.html#carousel
 * ==========================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */


!function (jq18) {

  "use strict"; // jshint ;_;


 /* CAROUSEL CLASS DEFINITION
  * ========================= */

  var Carousel = function (element, options) {
    this.jq18element = jq18(element)
    this.options = options
    this.options.slide && this.slide(this.options.slide)
    this.options.pause == 'hover' && this.jq18element
      .on('mouseenter', jq18.proxy(this.pause, this))
      .on('mouseleave', jq18.proxy(this.cycle, this))
  }

  Carousel.prototype = {

    cycle: function (e) {
      if (!e) this.paused = false
      this.options.interval
        && !this.paused
        && (this.interval = setInterval(jq18.proxy(this.next, this), this.options.interval))
      return this
    }

  , to: function (pos) {
      var jq18active = this.jq18element.find('.active')
        , children = jq18active.parent().children()
        , activePos = children.index(jq18active)
        , that = this

      if (pos > (children.length - 1) || pos < 0) return

      if (this.sliding) {
        return this.jq18element.one('slid', function () {
          that.to(pos)
        })
      }

      if (activePos == pos) {
        return this.pause().cycle()
      }

      return this.slide(pos > activePos ? 'next' : 'prev', jq18(children[pos]))
    }

  , pause: function (e) {
      if (!e) this.paused = true
      clearInterval(this.interval)
      this.interval = null
      return this
    }

  , next: function () {
      if (this.sliding) return
      return this.slide('next')
    }

  , prev: function () {
      if (this.sliding) return
      return this.slide('prev')
    }

  , slide: function (type, next) {
      var jq18active = this.jq18element.find('.active')
        , jq18next = next || jq18active[type]()
        , isCycling = this.interval
        , direction = type == 'next' ? 'left' : 'right'
        , fallback  = type == 'next' ? 'first' : 'last'
        , that = this
        , e = jq18.Event('slide')

      this.sliding = true

      isCycling && this.pause()

      jq18next = jq18next.length ? jq18next : this.jq18element.find('.item')[fallback]()

      if (jq18next.hasClass('active')) return

      if (jq18.support.transition && this.jq18element.hasClass('slide')) {
        this.jq18element.trigger(e)
        if (e.isDefaultPrevented()) return
        jq18next.addClass(type)
        jq18next[0].offsetWidth // force reflow
        jq18active.addClass(direction)
        jq18next.addClass(direction)
        this.jq18element.one(jq18.support.transition.end, function () {
          jq18next.removeClass([type, direction].join(' ')).addClass('active')
          jq18active.removeClass(['active', direction].join(' '))
          that.sliding = false
          setTimeout(function () { that.jq18element.trigger('slid') }, 0)
        })
      } else {
        this.jq18element.trigger(e)
        if (e.isDefaultPrevented()) return
        jq18active.removeClass('active')
        jq18next.addClass('active')
        this.sliding = false
        this.jq18element.trigger('slid')
      }

      isCycling && this.cycle()

      return this
    }

  }


 /* CAROUSEL PLUGIN DEFINITION
  * ========================== */

  jq18.fn.carousel = function (option) {
    return this.each(function () {
      var jq18this = jq18(this)
        , data = jq18this.data('carousel')
        , options = jq18.extend({}, jq18.fn.carousel.defaults, typeof option == 'object' && option)
      if (!data) jq18this.data('carousel', (data = new Carousel(this, options)))
      if (typeof option == 'number') data.to(option)
      else if (typeof option == 'string' || (option = options.slide)) data[option]()
      else if (options.interval) data.cycle()
    })
  }

  jq18.fn.carousel.defaults = {
    interval: 5000
  , pause: 'hover'
  }

  jq18.fn.carousel.Constructor = Carousel


 /* CAROUSEL DATA-API
  * ================= */

  jq18(function () {
    jq18('body').on('click.carousel.data-api', '[data-slide]', function ( e ) {
      var jq18this = jq18(this), href
        , jq18target = jq18(jq18this.attr('data-target') || (href = jq18this.attr('href')) && href.replace(/.*(?=#[^\s]+jq18)/, '')) //strip for ie7
        , options = !jq18target.data('modal') && jq18.extend({}, jq18target.data(), jq18this.data())
      jq18target.carousel(options)
      e.preventDefault()
    })
  })

}(window.jQuery);/* =============================================================
 * bootstrap-collapse.js v2.0.4
 * http://twitter.github.com/bootstrap/javascript.html#collapse
 * =============================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */


!function (jq18) {

  "use strict"; // jshint ;_;


 /* COLLAPSE PUBLIC CLASS DEFINITION
  * ================================ */

  var Collapse = function (element, options) {
    this.jq18element = jq18(element)
    this.options = jq18.extend({}, jq18.fn.collapse.defaults, options)

    if (this.options.parent) {
      this.jq18parent = jq18(this.options.parent)
    }

    this.options.toggle && this.toggle()
  }

  Collapse.prototype = {

    constructor: Collapse

  , dimension: function () {
      var hasWidth = this.jq18element.hasClass('width')
      return hasWidth ? 'width' : 'height'
    }

  , show: function () {
      var dimension
        , scroll
        , actives
        , hasData

      if (this.transitioning) return

      dimension = this.dimension()
      scroll = jq18.camelCase(['scroll', dimension].join('-'))
      actives = this.jq18parent && this.jq18parent.find('> .accordion-group > .in')

      if (actives && actives.length) {
        hasData = actives.data('collapse')
        if (hasData && hasData.transitioning) return
        actives.collapse('hide')
        hasData || actives.data('collapse', null)
      }

      this.jq18element[dimension](0)
      this.transition('addClass', jq18.Event('show'), 'shown')
      this.jq18element[dimension](this.jq18element[0][scroll])
    }

  , hide: function () {
      var dimension
      if (this.transitioning) return
      dimension = this.dimension()
      this.reset(this.jq18element[dimension]())
      this.transition('removeClass', jq18.Event('hide'), 'hidden')
      this.jq18element[dimension](0)
    }

  , reset: function (size) {
      var dimension = this.dimension()

      this.jq18element
        .removeClass('collapse')
        [dimension](size || 'auto')
        [0].offsetWidth

      this.jq18element[size !== null ? 'addClass' : 'removeClass']('collapse')

      return this
    }

  , transition: function (method, startEvent, completeEvent) {
      var that = this
        , complete = function () {
            if (startEvent.type == 'show') that.reset()
            that.transitioning = 0
            that.jq18element.trigger(completeEvent)
          }

      this.jq18element.trigger(startEvent)

      if (startEvent.isDefaultPrevented()) return

      this.transitioning = 1

      this.jq18element[method]('in')

      jq18.support.transition && this.jq18element.hasClass('collapse') ?
        this.jq18element.one(jq18.support.transition.end, complete) :
        complete()
    }

  , toggle: function () {
      this[this.jq18element.hasClass('in') ? 'hide' : 'show']()
    }

  }


 /* COLLAPSIBLE PLUGIN DEFINITION
  * ============================== */

  jq18.fn.collapse = function (option) {
    return this.each(function () {
      var jq18this = jq18(this)
        , data = jq18this.data('collapse')
        , options = typeof option == 'object' && option
      if (!data) jq18this.data('collapse', (data = new Collapse(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  jq18.fn.collapse.defaults = {
    toggle: true
  }

  jq18.fn.collapse.Constructor = Collapse


 /* COLLAPSIBLE DATA-API
  * ==================== */

  jq18(function () {
    jq18('body').on('click.collapse.data-api', '[data-toggle=collapse]', function ( e ) {
      var jq18this = jq18(this), href
        , target = jq18this.attr('data-target')
          || e.preventDefault()
          || (href = jq18this.attr('href')) && href.replace(/.*(?=#[^\s]+jq18)/, '') //strip for ie7
        , option = jq18(target).data('collapse') ? 'toggle' : jq18this.data()
      jq18(target).collapse(option)
    })
  })

}(window.jQuery);/* ============================================================
 * bootstrap-dropdown.js v2.0.4
 * http://twitter.github.com/bootstrap/javascript.html#dropdowns
 * ============================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */


!function (jq18) {

  "use strict"; // jshint ;_;


 /* DROPDOWN CLASS DEFINITION
  * ========================= */

  var toggle = '[data-toggle="dropdown"]'
    , Dropdown = function (element) {
        var jq18el = jq18(element).on('click.dropdown.data-api', this.toggle)
        jq18('html').on('click.dropdown.data-api', function () {
          jq18el.parent().removeClass('open')
        })
      }

  Dropdown.prototype = {

    constructor: Dropdown

  , toggle: function (e) {
      var jq18this = jq18(this)
        , jq18parent
        , selector
        , isActive

      if (jq18this.is('.disabled, :disabled')) return

      selector = jq18this.attr('data-target')

      if (!selector) {
        selector = jq18this.attr('href')
        selector = selector && selector.replace(/.*(?=#[^\s]*jq18)/, '') //strip for ie7
      }

      jq18parent = jq18(selector)
      jq18parent.length || (jq18parent = jq18this.parent())

      isActive = jq18parent.hasClass('open')

      clearMenus()

      if (!isActive) jq18parent.toggleClass('open')

      return false
    }

  }

  function clearMenus() {
    jq18(toggle).parent().removeClass('open')
  }


  /* DROPDOWN PLUGIN DEFINITION
   * ========================== */

  jq18.fn.dropdown = function (option) {
    return this.each(function () {
      var jq18this = jq18(this)
        , data = jq18this.data('dropdown')
      if (!data) jq18this.data('dropdown', (data = new Dropdown(this)))
      if (typeof option == 'string') data[option].call(jq18this)
    })
  }

  jq18.fn.dropdown.Constructor = Dropdown


  /* APPLY TO STANDARD DROPDOWN ELEMENTS
   * =================================== */

  jq18(function () {
    jq18('html').on('click.dropdown.data-api', clearMenus)
    jq18('body')
      .on('click.dropdown', '.dropdown form', function (e) { e.stopPropagation() })
      .on('click.dropdown.data-api', toggle, Dropdown.prototype.toggle)
  })

}(window.jQuery);/* =========================================================
 * bootstrap-modal.js v2.0.4
 * http://twitter.github.com/bootstrap/javascript.html#modals
 * =========================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================= */


!function (jq18) {

  "use strict"; // jshint ;_;


 /* MODAL CLASS DEFINITION
  * ====================== */

  var Modal = function (content, options) {
    this.options = options
    this.jq18element = jq18(content)
      .delegate('[data-dismiss="modal"]', 'click.dismiss.modal', jq18.proxy(this.hide, this))
  }

  Modal.prototype = {

      constructor: Modal

    , toggle: function () {
        return this[!this.isShown ? 'show' : 'hide']()
      }

    , show: function () {
        var that = this
          , e = jq18.Event('show')

        this.jq18element.trigger(e)

        if (this.isShown || e.isDefaultPrevented()) return

        jq18('body').addClass('modal-open')

        this.isShown = true

        escape.call(this)
        backdrop.call(this, function () {
          var transition = jq18.support.transition && that.jq18element.hasClass('fade')

          if (!that.jq18element.parent().length) {
            that.jq18element.appendTo(document.body) //don't move modals dom position
          }

          that.jq18element
            .show()

          if (transition) {
            that.jq18element[0].offsetWidth // force reflow
          }

          that.jq18element.addClass('in')

          transition ?
            that.jq18element.one(jq18.support.transition.end, function () { that.jq18element.trigger('shown') }) :
            that.jq18element.trigger('shown')

        })
      }

    , hide: function (e) {
        e && e.preventDefault()

        var that = this

        e = jq18.Event('hide')

        this.jq18element.trigger(e)

        if (!this.isShown || e.isDefaultPrevented()) return

        this.isShown = false

        jq18('body').removeClass('modal-open')

        escape.call(this)

        this.jq18element.removeClass('in')

        jq18.support.transition && this.jq18element.hasClass('fade') ?
          hideWithTransition.call(this) :
          hideModal.call(this)
      }

  }


 /* MODAL PRIVATE METHODS
  * ===================== */

  function hideWithTransition() {
    var that = this
      , timeout = setTimeout(function () {
          that.jq18element.off(jq18.support.transition.end)
          hideModal.call(that)
        }, 500)

    this.jq18element.one(jq18.support.transition.end, function () {
      clearTimeout(timeout)
      hideModal.call(that)
    })
  }

  function hideModal(that) {
    this.jq18element
      .hide()
      .trigger('hidden')

    backdrop.call(this)
  }

  function backdrop(callback) {
    var that = this
      , animate = this.jq18element.hasClass('fade') ? 'fade' : ''

    if (this.isShown && this.options.backdrop) {
      var doAnimate = jq18.support.transition && animate

      this.jq18backdrop = jq18('<div class="modal-backdrop ' + animate + '" />')
        .appendTo(document.body)

      if (this.options.backdrop != 'static') {
        this.jq18backdrop.click(jq18.proxy(this.hide, this))
      }

      if (doAnimate) this.jq18backdrop[0].offsetWidth // force reflow

      this.jq18backdrop.addClass('in')

      doAnimate ?
        this.jq18backdrop.one(jq18.support.transition.end, callback) :
        callback()

    } else if (!this.isShown && this.jq18backdrop) {
      this.jq18backdrop.removeClass('in')

      jq18.support.transition && this.jq18element.hasClass('fade')?
        this.jq18backdrop.one(jq18.support.transition.end, jq18.proxy(removeBackdrop, this)) :
        removeBackdrop.call(this)

    } else if (callback) {
      callback()
    }
  }

  function removeBackdrop() {
    this.jq18backdrop.remove()
    this.jq18backdrop = null
  }

  function escape() {
    var that = this
    if (this.isShown && this.options.keyboard) {
      jq18(document).on('keyup.dismiss.modal', function ( e ) {
        e.which == 27 && that.hide()
      })
    } else if (!this.isShown) {
      jq18(document).off('keyup.dismiss.modal')
    }
  }


 /* MODAL PLUGIN DEFINITION
  * ======================= */

  jq18.fn.modal = function (option) {
    return this.each(function () {
      var jq18this = jq18(this)
        , data = jq18this.data('modal')
        , options = jq18.extend({}, jq18.fn.modal.defaults, jq18this.data(), typeof option == 'object' && option)
      if (!data) jq18this.data('modal', (data = new Modal(this, options)))
      if (typeof option == 'string') data[option]()
      else if (options.show) data.show()
    })
  }

  jq18.fn.modal.defaults = {
      backdrop: true
    , keyboard: true
    , show: true
  }

  jq18.fn.modal.Constructor = Modal


 /* MODAL DATA-API
  * ============== */

  jq18(function () {
    jq18('body').on('click.modal.data-api', '[data-toggle="modal"]', function ( e ) {
      var jq18this = jq18(this), href
        , jq18target = jq18(jq18this.attr('data-target') || (href = jq18this.attr('href')) && href.replace(/.*(?=#[^\s]+jq18)/, '')) //strip for ie7
        , option = jq18target.data('modal') ? 'toggle' : jq18.extend({}, jq18target.data(), jq18this.data())

      e.preventDefault()
      jq18target.modal(option)
    })
  })

}(window.jQuery);/* ===========================================================
 * bootstrap-tooltip.js v2.0.4
 * http://twitter.github.com/bootstrap/javascript.html#tooltips
 * Inspired by the original jQuery.tipsy by Jason Frame
 * ===========================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */


!function (jq18) {

  "use strict"; // jshint ;_;


 /* TOOLTIP PUBLIC CLASS DEFINITION
  * =============================== */

  var Tooltip = function (element, options) {
    this.init('tooltip', element, options)
  }

  Tooltip.prototype = {

    constructor: Tooltip

  , init: function (type, element, options) {
      var eventIn
        , eventOut

      this.type = type
      this.jq18element = jq18(element)
      this.options = this.getOptions(options)
      this.enabled = true

      if (this.options.trigger != 'manual') {
        eventIn  = this.options.trigger == 'hover' ? 'mouseenter' : 'focus'
        eventOut = this.options.trigger == 'hover' ? 'mouseleave' : 'blur'
        this.jq18element.on(eventIn, this.options.selector, jq18.proxy(this.enter, this))
        this.jq18element.on(eventOut, this.options.selector, jq18.proxy(this.leave, this))
      }

      this.options.selector ?
        (this._options = jq18.extend({}, this.options, { trigger: 'manual', selector: '' })) :
        this.fixTitle()
    }

  , getOptions: function (options) {
      options = jq18.extend({}, jq18.fn[this.type].defaults, options, this.jq18element.data())

      if (options.delay && typeof options.delay == 'number') {
        options.delay = {
          show: options.delay
        , hide: options.delay
        }
      }

      return options
    }

  , enter: function (e) {
      var self = jq18(e.currentTarget)[this.type](this._options).data(this.type)

      if (!self.options.delay || !self.options.delay.show) return self.show()

      clearTimeout(this.timeout)
      self.hoverState = 'in'
      this.timeout = setTimeout(function() {
        if (self.hoverState == 'in') self.show()
      }, self.options.delay.show)
    }

  , leave: function (e) {
      var self = jq18(e.currentTarget)[this.type](this._options).data(this.type)

      if (this.timeout) clearTimeout(this.timeout)
      if (!self.options.delay || !self.options.delay.hide) return self.hide()

      self.hoverState = 'out'
      this.timeout = setTimeout(function() {
        if (self.hoverState == 'out') self.hide()
      }, self.options.delay.hide)
    }

  , show: function () {
      var jq18tip
        , inside
        , pos
        , actualWidth
        , actualHeight
        , placement
        , tp

      if (this.hasContent() && this.enabled) {
        jq18tip = this.tip()
        this.setContent()

        if (this.options.animation) {
          jq18tip.addClass('fade')
        }

        placement = typeof this.options.placement == 'function' ?
          this.options.placement.call(this, jq18tip[0], this.jq18element[0]) :
          this.options.placement

        inside = /in/.test(placement)

        jq18tip
          .remove()
          .css({ top: 0, left: 0, display: 'block' })
          .appendTo(inside ? this.jq18element : document.body)

        pos = this.getPosition(inside)

        actualWidth = jq18tip[0].offsetWidth
        actualHeight = jq18tip[0].offsetHeight

        switch (inside ? placement.split(' ')[1] : placement) {
          case 'bottom':
            tp = {top: pos.top + pos.height, left: pos.left + pos.width / 2 - actualWidth / 2}
            break
          case 'top':
            tp = {top: pos.top - actualHeight, left: pos.left + pos.width / 2 - actualWidth / 2}
            break
          case 'left':
            tp = {top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth}
            break
          case 'right':
            tp = {top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width}
            break
        }

        jq18tip
          .css(tp)
          .addClass(placement)
          .addClass('in')
      }
    }

  , isHTML: function(text) {
      // html string detection logic adapted from jQuery
      return typeof text != 'string'
        || ( text.charAt(0) === "<"
          && text.charAt( text.length - 1 ) === ">"
          && text.length >= 3
        ) || /^(?:[^<]*<[\w\W]+>[^>]*jq18)/.exec(text)
    }

  , setContent: function () {
      var jq18tip = this.tip()
        , title = this.getTitle()

      jq18tip.find('.tooltip-inner')[this.isHTML(title) ? 'html' : 'text'](title)
      jq18tip.removeClass('fade in top bottom left right')
    }

  , hide: function () {
      var that = this
        , jq18tip = this.tip()

      jq18tip.removeClass('in')

      function removeWithAnimation() {
        var timeout = setTimeout(function () {
          jq18tip.off(jq18.support.transition.end).remove()
        }, 500)

        jq18tip.one(jq18.support.transition.end, function () {
          clearTimeout(timeout)
          jq18tip.remove()
        })
      }

      jq18.support.transition && this.jq18tip.hasClass('fade') ?
        removeWithAnimation() :
        jq18tip.remove()
    }

  , fixTitle: function () {
      var jq18e = this.jq18element
      if (jq18e.attr('title') || typeof(jq18e.attr('data-original-title')) != 'string') {
        jq18e.attr('data-original-title', jq18e.attr('title') || '').removeAttr('title')
      }
    }

  , hasContent: function () {
      return this.getTitle()
    }

  , getPosition: function (inside) {
      return jq18.extend({}, (inside ? {top: 0, left: 0} : this.jq18element.offset()), {
        width: this.jq18element[0].offsetWidth
      , height: this.jq18element[0].offsetHeight
      })
    }

  , getTitle: function () {
      var title
        , jq18e = this.jq18element
        , o = this.options

      title = jq18e.attr('data-original-title')
        || (typeof o.title == 'function' ? o.title.call(jq18e[0]) :  o.title)

      return title
    }

  , tip: function () {
      return this.jq18tip = this.jq18tip || jq18(this.options.template)
    }

  , validate: function () {
      if (!this.jq18element[0].parentNode) {
        this.hide()
        this.jq18element = null
        this.options = null
      }
    }

  , enable: function () {
      this.enabled = true
    }

  , disable: function () {
      this.enabled = false
    }

  , toggleEnabled: function () {
      this.enabled = !this.enabled
    }

  , toggle: function () {
      this[this.tip().hasClass('in') ? 'hide' : 'show']()
    }

  }


 /* TOOLTIP PLUGIN DEFINITION
  * ========================= */

  jq18.fn.tooltip = function ( option ) {
    return this.each(function () {
      var jq18this = jq18(this)
        , data = jq18this.data('tooltip')
        , options = typeof option == 'object' && option
      if (!data) jq18this.data('tooltip', (data = new Tooltip(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  jq18.fn.tooltip.Constructor = Tooltip

  jq18.fn.tooltip.defaults = {
    animation: true
  , placement: 'top'
  , selector: false
  , template: '<div class="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
  , trigger: 'hover'
  , title: ''
  , delay: 0
  }

}(window.jQuery);
/* ===========================================================
 * bootstrap-popover.js v2.0.4
 * http://twitter.github.com/bootstrap/javascript.html#popovers
 * ===========================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * =========================================================== */


!function (jq18) {

  "use strict"; // jshint ;_;


 /* POPOVER PUBLIC CLASS DEFINITION
  * =============================== */

  var Popover = function ( element, options ) {
    this.init('popover', element, options)
  }


  /* NOTE: POPOVER EXTENDS BOOTSTRAP-TOOLTIP.js
     ========================================== */

  Popover.prototype = jq18.extend({}, jq18.fn.tooltip.Constructor.prototype, {

    constructor: Popover

  , setContent: function () {
      var jq18tip = this.tip()
        , title = this.getTitle()
        , content = this.getContent()

      jq18tip.find('.popover-title')[this.isHTML(title) ? 'html' : 'text'](title)
      jq18tip.find('.popover-content > *')[this.isHTML(content) ? 'html' : 'text'](content)

      jq18tip.removeClass('fade top bottom left right in')
    }

  , hasContent: function () {
      return this.getTitle() || this.getContent()
    }

  , getContent: function () {
      var content
        , jq18e = this.jq18element
        , o = this.options

      content = jq18e.attr('data-content')
        || (typeof o.content == 'function' ? o.content.call(jq18e[0]) :  o.content)

      return content
    }

  , tip: function () {
      if (!this.jq18tip) {
        this.jq18tip = jq18(this.options.template)
      }
      return this.jq18tip
    }

  })


 /* POPOVER PLUGIN DEFINITION
  * ======================= */

  jq18.fn.popover = function (option) {
    return this.each(function () {
      var jq18this = jq18(this)
        , data = jq18this.data('popover')
        , options = typeof option == 'object' && option
      if (!data) jq18this.data('popover', (data = new Popover(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  jq18.fn.popover.Constructor = Popover

  jq18.fn.popover.defaults = jq18.extend({} , jq18.fn.tooltip.defaults, {
    placement: 'right'
  , content: ''
  , template: '<div class="popover"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>'
  })

}(window.jQuery);/* =============================================================
 * bootstrap-scrollspy.js v2.0.4
 * http://twitter.github.com/bootstrap/javascript.html#scrollspy
 * =============================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================== */


!function (jq18) {

  "use strict"; // jshint ;_;


  /* SCROLLSPY CLASS DEFINITION
   * ========================== */

  function ScrollSpy( element, options) {
    var process = jq18.proxy(this.process, this)
      , jq18element = jq18(element).is('body') ? jq18(window) : jq18(element)
      , href
    this.options = jq18.extend({}, jq18.fn.scrollspy.defaults, options)
    this.jq18scrollElement = jq18element.on('scroll.scroll.data-api', process)
    this.selector = (this.options.target
      || ((href = jq18(element).attr('href')) && href.replace(/.*(?=#[^\s]+jq18)/, '')) //strip for ie7
      || '') + ' .nav li > a'
    this.jq18body = jq18('body')
    this.refresh()
    this.process()
  }

  ScrollSpy.prototype = {

      constructor: ScrollSpy

    , refresh: function () {
        var self = this
          , jq18targets

        this.offsets = jq18([])
        this.targets = jq18([])

        jq18targets = this.jq18body
          .find(this.selector)
          .map(function () {
            var jq18el = jq18(this)
              , href = jq18el.data('target') || jq18el.attr('href')
              , jq18href = /^#\w/.test(href) && jq18(href)
            return ( jq18href
              && href.length
              && [[ jq18href.position().top, href ]] ) || null
          })
          .sort(function (a, b) { return a[0] - b[0] })
          .each(function () {
            self.offsets.push(this[0])
            self.targets.push(this[1])
          })
      }

    , process: function () {
        var scrollTop = this.jq18scrollElement.scrollTop() + this.options.offset
          , scrollHeight = this.jq18scrollElement[0].scrollHeight || this.jq18body[0].scrollHeight
          , maxScroll = scrollHeight - this.jq18scrollElement.height()
          , offsets = this.offsets
          , targets = this.targets
          , activeTarget = this.activeTarget
          , i

        if (scrollTop >= maxScroll) {
          return activeTarget != (i = targets.last()[0])
            && this.activate ( i )
        }

        for (i = offsets.length; i--;) {
          activeTarget != targets[i]
            && scrollTop >= offsets[i]
            && (!offsets[i + 1] || scrollTop <= offsets[i + 1])
            && this.activate( targets[i] )
        }
      }

    , activate: function (target) {
        var active
          , selector

        this.activeTarget = target

        jq18(this.selector)
          .parent('.active')
          .removeClass('active')

        selector = this.selector
          + '[data-target="' + target + '"],'
          + this.selector + '[href="' + target + '"]'

        active = jq18(selector)
          .parent('li')
          .addClass('active')

        if (active.parent('.dropdown-menu'))  {
          active = active.closest('li.dropdown').addClass('active')
        }

        active.trigger('activate')
      }

  }


 /* SCROLLSPY PLUGIN DEFINITION
  * =========================== */

  jq18.fn.scrollspy = function ( option ) {
    return this.each(function () {
      var jq18this = jq18(this)
        , data = jq18this.data('scrollspy')
        , options = typeof option == 'object' && option
      if (!data) jq18this.data('scrollspy', (data = new ScrollSpy(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  jq18.fn.scrollspy.Constructor = ScrollSpy

  jq18.fn.scrollspy.defaults = {
    offset: 10
  }


 /* SCROLLSPY DATA-API
  * ================== */

  jq18(function () {
    jq18('[data-spy="scroll"]').each(function () {
      var jq18spy = jq18(this)
      jq18spy.scrollspy(jq18spy.data())
    })
  })

}(window.jQuery);/* ========================================================
 * bootstrap-tab.js v2.0.4
 * http://twitter.github.com/bootstrap/javascript.html#tabs
 * ========================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ======================================================== */


!function (jq18) {

  "use strict"; // jshint ;_;


 /* TAB CLASS DEFINITION
  * ==================== */

  var Tab = function ( element ) {
    this.element = jq18(element)
  }

  Tab.prototype = {

    constructor: Tab

  , show: function () {
      var jq18this = this.element
        , jq18ul = jq18this.closest('ul:not(.dropdown-menu)')
        , selector = jq18this.attr('data-target')
        , previous
        , jq18target
        , e

      if (!selector) {
        selector = jq18this.attr('href')
        selector = selector && selector.replace(/.*(?=#[^\s]*jq18)/, '') //strip for ie7
      }

      if ( jq18this.parent('li').hasClass('active') ) return

      previous = jq18ul.find('.active a').last()[0]

      e = jq18.Event('show', {
        relatedTarget: previous
      })

      jq18this.trigger(e)

      if (e.isDefaultPrevented()) return

      jq18target = jq18(selector)

      this.activate(jq18this.parent('li'), jq18ul)
      this.activate(jq18target, jq18target.parent(), function () {
        jq18this.trigger({
          type: 'shown'
        , relatedTarget: previous
        })
      })
    }

  , activate: function ( element, container, callback) {
      var jq18active = container.find('> .active')
        , transition = callback
            && jq18.support.transition
            && jq18active.hasClass('fade')

      function next() {
        jq18active
          .removeClass('active')
          .find('> .dropdown-menu > .active')
          .removeClass('active')

        element.addClass('active')

        if (transition) {
          element[0].offsetWidth // reflow for transition
          element.addClass('in')
        } else {
          element.removeClass('fade')
        }

        if ( element.parent('.dropdown-menu') ) {
          element.closest('li.dropdown').addClass('active')
        }

        callback && callback()
      }

      transition ?
        jq18active.one(jq18.support.transition.end, next) :
        next()

      jq18active.removeClass('in')
    }
  }


 /* TAB PLUGIN DEFINITION
  * ===================== */

  jq18.fn.tab = function ( option ) {
    return this.each(function () {
      var jq18this = jq18(this)
        , data = jq18this.data('tab')
      if (!data) jq18this.data('tab', (data = new Tab(this)))
      if (typeof option == 'string') data[option]()
    })
  }

  jq18.fn.tab.Constructor = Tab


 /* TAB DATA-API
  * ============ */

  jq18(function () {
    jq18('body').on('click.tab.data-api', '[data-toggle="tab"], [data-toggle="pill"]', function (e) {
      e.preventDefault()
      jq18(this).tab('show')
    })
  })

}(window.jQuery);/* =============================================================
 * bootstrap-typeahead.js v2.0.4
 * http://twitter.github.com/bootstrap/javascript.html#typeahead
 * =============================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */


!function(jq18){

  "use strict"; // jshint ;_;


 /* TYPEAHEAD PUBLIC CLASS DEFINITION
  * ================================= */

  var Typeahead = function (element, options) {
    this.jq18element = jq18(element)
    this.options = jq18.extend({}, jq18.fn.typeahead.defaults, options)
    this.matcher = this.options.matcher || this.matcher
    this.sorter = this.options.sorter || this.sorter
    this.highlighter = this.options.highlighter || this.highlighter
    this.updater = this.options.updater || this.updater
    this.jq18menu = jq18(this.options.menu).appendTo('body')
    this.source = this.options.source
    this.shown = false
    this.listen()
  }

  Typeahead.prototype = {

    constructor: Typeahead

  , select: function () {
      var val = this.jq18menu.find('.active').attr('data-value')
      this.jq18element
        .val(this.updater(val))
        .change()
      return this.hide()
    }

  , updater: function (item) {
      return item
    }

  , show: function () {
      var pos = jq18.extend({}, this.jq18element.offset(), {
        height: this.jq18element[0].offsetHeight
      })

      this.jq18menu.css({
        top: pos.top + pos.height
      , left: pos.left
      })

      this.jq18menu.show()
      this.shown = true
      return this
    }

  , hide: function () {
      this.jq18menu.hide()
      this.shown = false
      return this
    }

  , lookup: function (event) {
      var that = this
        , items
        , q

      this.query = this.jq18element.val()

      if (!this.query) {
        return this.shown ? this.hide() : this
      }

      items = jq18.grep(this.source, function (item) {
        return that.matcher(item)
      })

      items = this.sorter(items)

      if (!items.length) {
        return this.shown ? this.hide() : this
      }

      return this.render(items.slice(0, this.options.items)).show()
    }

  , matcher: function (item) {
      return ~item.toLowerCase().indexOf(this.query.toLowerCase())
    }

  , sorter: function (items) {
      var beginswith = []
        , caseSensitive = []
        , caseInsensitive = []
        , item

      while (item = items.shift()) {
        if (!item.toLowerCase().indexOf(this.query.toLowerCase())) beginswith.push(item)
        else if (~item.indexOf(this.query)) caseSensitive.push(item)
        else caseInsensitive.push(item)
      }

      return beginswith.concat(caseSensitive, caseInsensitive)
    }

  , highlighter: function (item) {
      var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^jq18|#\s]/g, '\\jq18&')
      return item.replace(new RegExp('(' + query + ')', 'ig'), function (jq181, match) {
        return '<strong>' + match + '</strong>'
      })
    }

  , render: function (items) {
      var that = this

      items = jq18(items).map(function (i, item) {
        i = jq18(that.options.item).attr('data-value', item)
        i.find('a').html(that.highlighter(item))
        return i[0]
      })

      items.first().addClass('active')
      this.jq18menu.html(items)
      return this
    }

  , next: function (event) {
      var active = this.jq18menu.find('.active').removeClass('active')
        , next = active.next()

      if (!next.length) {
        next = jq18(this.jq18menu.find('li')[0])
      }

      next.addClass('active')
    }

  , prev: function (event) {
      var active = this.jq18menu.find('.active').removeClass('active')
        , prev = active.prev()

      if (!prev.length) {
        prev = this.jq18menu.find('li').last()
      }

      prev.addClass('active')
    }

  , listen: function () {
      this.jq18element
        .on('blur',     jq18.proxy(this.blur, this))
        .on('keypress', jq18.proxy(this.keypress, this))
        .on('keyup',    jq18.proxy(this.keyup, this))

      if (jq18.browser.webkit || jq18.browser.msie) {
        this.jq18element.on('keydown', jq18.proxy(this.keypress, this))
      }

      this.jq18menu
        .on('click', jq18.proxy(this.click, this))
        .on('mouseenter', 'li', jq18.proxy(this.mouseenter, this))
    }

  , keyup: function (e) {
      switch(e.keyCode) {
        case 40: // down arrow
        case 38: // up arrow
          break

        case 9: // tab
        case 13: // enter
          if (!this.shown) return
          this.select()
          break

        case 27: // escape
          if (!this.shown) return
          this.hide()
          break

        default:
          this.lookup()
      }

      e.stopPropagation()
      e.preventDefault()
  }

  , keypress: function (e) {
      if (!this.shown) return

      switch(e.keyCode) {
        case 9: // tab
        case 13: // enter
        case 27: // escape
          e.preventDefault()
          break

        case 38: // up arrow
          if (e.type != 'keydown') break
          e.preventDefault()
          this.prev()
          break

        case 40: // down arrow
          if (e.type != 'keydown') break
          e.preventDefault()
          this.next()
          break
      }

      e.stopPropagation()
    }

  , blur: function (e) {
      var that = this
      setTimeout(function () { that.hide() }, 150)
    }

  , click: function (e) {
      e.stopPropagation()
      e.preventDefault()
      this.select()
    }

  , mouseenter: function (e) {
      this.jq18menu.find('.active').removeClass('active')
      jq18(e.currentTarget).addClass('active')
    }

  }


  /* TYPEAHEAD PLUGIN DEFINITION
   * =========================== */

  jq18.fn.typeahead = function (option) {
    return this.each(function () {
      var jq18this = jq18(this)
        , data = jq18this.data('typeahead')
        , options = typeof option == 'object' && option
      if (!data) jq18this.data('typeahead', (data = new Typeahead(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  jq18.fn.typeahead.defaults = {
    source: []
  , items: 8
  , menu: '<ul class="typeahead dropdown-menu"></ul>'
  , item: '<li><a href="#"></a></li>'
  }

  jq18.fn.typeahead.Constructor = Typeahead


 /* TYPEAHEAD DATA-API
  * ================== */

  jq18(function () {
    jq18('body').on('focus.typeahead.data-api', '[data-provide="typeahead"]', function (e) {
      var jq18this = jq18(this)
      if (jq18this.data('typeahead')) return
      e.preventDefault()
      jq18this.typeahead(jq18this.data())
    })
  })

}(window.jQuery);