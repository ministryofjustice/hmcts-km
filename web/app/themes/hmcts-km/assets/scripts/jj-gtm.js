/**
 * The data layer management script for GTM
 */

mojGtm = [{}];

(function (w, d, s, l, i) {
  w[l] = w[l] || []
  w[l].push({
    'gtm.start':
            new Date().getTime(),
    event: 'gtm.js'
  })
  var f = d.getElementsByTagName(s)[0]
  var j = d.createElement(s); var dl = l != 'dataLayer' ? '&l=' + l : ''
  j.async = true
  j.src =
        'https://www.googletagmanager.com/gtm.js?id=' + i + dl
  f.parentNode.insertBefore(j, f)
})(window, document, 'script', 'mojGtm', 'GTM-TR2KWT6')

/**
 * This function wraps around the dataLayer.push function
 * @param event
 * @param object
 * @private
 */
function _trackEvent (event, object) {
  if (!object) {
    var message = 'MoJ: Custom function _trackEvent() should include an object of variable name-value pairs'
    if (!console && !console.warn) {
      alert(message)
    } else {
      console.warn(message)
    }
    mojGtm.push({ event: event })
    return
  }

  mojGtm.push($.extend({}, { event: event }, object))
}

function _jq_target (event) {
  return $(event.target)
}
