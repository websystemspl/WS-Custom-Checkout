//from http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.js?ver=5.0.4
(function($) {
    /*var $document = $( document ),
        supportTouch = $.mobile.support.touch,
        scrollEvent = "touchmove scroll",
        touchStartEvent = supportTouch ? "touchstart" : "mousedown",
        touchStopEvent = supportTouch ? "touchend" : "mouseup",
        touchMoveEvent = supportTouch ? "touchmove" : "mousemove";*/
    var $document = $( document ),
        scrollEvent = "touchmove scroll",
        touchStartEvent = "touchstart mousedown",
        touchStopEvent = "touchend mouseup",
        touchMoveEvent = "touchmove mousemove";
    function triggerCustomEvent( obj, eventType, event, bubble ) {
        var originalType = event.type;
        event.type = eventType;
        if ( bubble ) {
            $.event.trigger( event, undefined, obj );
        } else {
            $.event.dispatch.call( obj, event );
        }
        event.type = originalType;
    }
    $.event.special.swipe = {

        // More than this horizontal displacement, and we will suppress scrolling.
        scrollSupressionThreshold: 30,

        // More time than this, and it isn't a swipe.
        durationThreshold: 1000,

        // Swipe horizontal displacement must be more than this.
        horizontalDistanceThreshold: 30,

        // Swipe vertical displacement must be less than this.
        verticalDistanceThreshold: 30,

        getLocation: function ( event ) {
            var winPageX = window.pageXOffset,
                winPageY = window.pageYOffset,
                x = event.clientX,
                y = event.clientY;

            if ( event.pageY === 0 && Math.floor( y ) > Math.floor( event.pageY ) ||
                event.pageX === 0 && Math.floor( x ) > Math.floor( event.pageX ) ) {

                // iOS4 clientX/clientY have the value that should have been
                // in pageX/pageY. While pageX/page/ have the value 0
                x = x - winPageX;
                y = y - winPageY;
            } else if ( y < ( event.pageY - winPageY) || x < ( event.pageX - winPageX ) ) {

                // Some Android browsers have totally bogus values for clientX/Y
                // when scrolling/zooming a page. Detectable since clientX/clientY
                // should never be smaller than pageX/pageY minus page scroll
                x = event.pageX - winPageX;
                y = event.pageY - winPageY;
            }

            return {
                x: x,
                y: y
            };
        },

        start: function( event ) {
            var data = event.originalEvent.touches ?
                    event.originalEvent.touches[ 0 ] : event,
                location = $.event.special.swipe.getLocation( data );
            return {
                        time: ( new Date() ).getTime(),
                        coords: [ location.x, location.y ],
                        origin: $( event.target )
                    };
        },

        stop: function( event ) {
            var data = event.originalEvent.touches ?
                    event.originalEvent.touches[ 0 ] : event,
                location = $.event.special.swipe.getLocation( data );
            return {
                        time: ( new Date() ).getTime(),
                        coords: [ location.x, location.y ]
                    };
        },

        handleSwipe: function( start, stop, thisObject, origTarget ) {
            if ( stop.time - start.time < $.event.special.swipe.durationThreshold &&
                Math.abs( start.coords[ 0 ] - stop.coords[ 0 ] ) > $.event.special.swipe.horizontalDistanceThreshold &&
                Math.abs( start.coords[ 1 ] - stop.coords[ 1 ] ) < $.event.special.swipe.verticalDistanceThreshold ) {
                var direction = start.coords[0] > stop.coords[ 0 ] ? "swipeleft" : "swiperight";

                triggerCustomEvent( thisObject, "swipe", $.Event( "swipe", { target: origTarget, swipestart: start, swipestop: stop }), true );
                triggerCustomEvent( thisObject, direction,$.Event( direction, { target: origTarget, swipestart: start, swipestop: stop } ), true );
                return true;
            }
            return false;

        },

        // This serves as a flag to ensure that at most one swipe event event is
        // in work at any given time
        eventInProgress: false,

        setup: function() {
            var events,
                thisObject = this,
                $this = $( thisObject ),
                context = {};

            // Retrieve the events data for this element and add the swipe context
            events = $.data( this, "mobile-events" );
            if ( !events ) {
                events = { length: 0 };
                $.data( this, "mobile-events", events );
            }
            events.length++;
            events.swipe = context;

            context.start = function( event ) {

                // Bail if we're already working on a swipe event
                if ( $.event.special.swipe.eventInProgress ) {
                    return;
                }
                $.event.special.swipe.eventInProgress = true;

                var stop,
                    start = $.event.special.swipe.start( event ),
                    origTarget = event.target,
                    emitted = false;

                context.move = function( event ) {
                    if ( !start || event.isDefaultPrevented() ) {
                        return;
                    }

                    stop = $.event.special.swipe.stop( event );
                    if ( !emitted ) {
                        emitted = $.event.special.swipe.handleSwipe( start, stop, thisObject, origTarget );
                        if ( emitted ) {

                            // Reset the context to make way for the next swipe event
                            $.event.special.swipe.eventInProgress = false;
                        }
                    }
                    
                    //commented due to [Intervention] Unable to preventDefault inside passive event listener due to target being treated as passive. See <URL>
                    // prevent scrolling
                    //if ( Math.abs( start.coords[ 0 ] - stop.coords[ 0 ] ) > $.event.special.swipe.scrollSupressionThreshold ) {
                        //event.preventDefault();
                    //}
                };

                context.stop = function() {
                        emitted = true;

                        // Reset the context to make way for the next swipe event
                        $.event.special.swipe.eventInProgress = false;
                        $document.off( touchMoveEvent, context.move );
                        context.move = null;
                };

                $document.on( touchMoveEvent, context.move )
                    .one( touchStopEvent, context.stop );
            };
            $this.on( touchStartEvent, context.start );
        },

        teardown: function() {
            var events, context;

            events = $.data( this, "mobile-events" );
            if ( events ) {
                context = events.swipe;
                delete events.swipe;
                events.length--;
                if ( events.length === 0 ) {
                    $.removeData( this, "mobile-events" );
                }
            }

            if ( context ) {
                if ( context.start ) {
                    $( this ).off( touchStartEvent, context.start );
                }
                if ( context.move ) {
                    $document.off( touchMoveEvent, context.move );
                }
                if ( context.stop ) {
                    $document.off( touchStopEvent, context.stop );
                }
            }
        }
    };
    $.each({
        scrollstop: "scrollstart",
        taphold: "tap",
        swipeleft: "swipe.left",
        swiperight: "swipe.right"
    }, function( event, sourceEvent ) {

        $.event.special[ event ] = {
            setup: function() {
                $( this ).bind( sourceEvent, $.noop );
            },
            teardown: function() {
                $( this ).unbind( sourceEvent );
            }
        };
    });
})( jQuery );