/*
 +-----------------------------------------------+
 | This file is part of chem-inventory.          |
 |                                               |
 | Copyright 2020                                |
 | Sandor Semsey <semseysandor@gmail.com>        |
 | All rights reserved.                          |
 |                                               |
 | This work is published under the MIT License. |
 | https://choosealicense.com/licenses/mit/      |
 +-----------------------------------------------+
 */
/**
 * jQuery plugin for pub/sub handling
 */
(function ($) {
    'use strict';

    $.pubsub = {};

    /**
     * Defaults
     *
     *   publisher: publisher jQuery object
     *   subscriber: subscriber jQuery object
     *   publishDelegate: Event delegation
     *   browserEvent: original event to register
     *   publishEvent: publisher event
     *   eventData: event data
     *   callBack: callback fn handle published event
     */
    $.pubsub.defaults = {
        publisher: null,
        subscriber: null,
        publishDelegate: null,
        browserEvent: 'click',
        publishEvent: 'publish:submit',
        eventData: {},
        callBack: jQuery.noop,
    };

    /**
     * Directly connect a publisher and a subscriber
     *
     * @param options
     *   publisher: publisher jQuery object
     *   subscriber: subscriber jQuery object
     *   publishDelegate: Event delegation
     *   browserEvent: original event to register
     *   publishEvent: publisher event
     *   eventData: event data
     *   callBack: callback fn handle published event
     */
    $.pubsub.connect = function (options) {

        // Get options
        let settings = $.extend({}, $.pubsub.defaults, options);

        // If no pub or sub --> exit
        if (!settings.publisher || !settings.subscriber) {
            return;
        }

        // Publish event
        settings.publisher.on(settings.browserEvent, settings.publishDelegate, settings.eventData, function (event) {
            event.preventDefault();
            settings.subscriber.trigger(settings.publishEvent, settings.eventData);
        });

        // Subscribe event
        settings.subscriber.on(settings.publishEvent, settings.callBack);
    };

    /**
     * Submit form wrapper
     *
     * @param $button Submit button jQuery obj
     * @param $form Form jQuery obj
     * @param callBack Callback fn
     */
    $.pubsub.submitForm = function ($button, $form, callBack) {
        $.pubsub.connect({
            publisher: $button,
            subscriber: $form,
            browserEvent: 'click',
            publishEvent: 'publish:submit',
            callBack: callBack,
        });
    };
})(jQuery);

