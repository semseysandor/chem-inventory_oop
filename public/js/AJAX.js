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
 * AJAX handling
 */
(function (Inventory, $) {
    'use strict';

    /**
     * Container for response from AJAX
     */
    let $responseContainer;

    /**
     * Call back function after successful AJAX
     */
    let callBack;

    /**
     * Response flag
     */
    let responseFlag;

    /**
     * Response text
     */
    let responseText;

    /**
     * AJAX functions
     */
    Inventory.AJAX = {};

    /**
     * Init request
     *
     * @param responseContainer Response container
     * @param callBackFn Callback function
     */
    function initRequest(responseContainer, callBackFn)
    {
        $responseContainer = responseContainer;
        callBack = $.isFunction(callBackFn) ? callBackFn : function () {
        };
        responseFlag = null;
        responseText = null;
    }

    /**
     * Reset form fields
     *
     * @param $form Form JQuery Object
     */
    function resetForm($form)
    {
        $form.find('input').each(function (index, element) {
            // Don't clear hidden inputs
            if (element.type !== 'hidden') {
                element.value = '';
            }
        });
    }

    /**
     * Parse JSON response
     *
     * @param response AJAX response
     */
    function parseResponse(response)
    {
        // Clear responseContainer
        $responseContainer.html('');

        // Parse response
        responseFlag = response.flag;
        responseText = response.text;

        // Show response
        $responseContainer.html(Inventory.messageHTML(responseText, responseFlag));
    }

    /**
     * Submit form using AJAX with JSON response
     *
     * @param $form Form jQuery object
     * @param $responseCont Form response container jQuery object
     * @param callBackFn Callback function
     */
    Inventory.AJAX.submit = function ($form, $responseCont, callBackFn) {

        // Init request
        initRequest($responseCont, callBackFn);

        $.ajax({
            url: $form.attr('action'),
            data: $form.serialize(),
            type: $form.attr('method'),
            dataType: 'json',
        }).done(
            function (response) {
                parseResponse(response);

                // If positive response --> perform callback
                if (responseFlag === 'pos') {
                    resetForm($form);
                    callBack();
                }
            }
        );
    };

    /**
     * HTTP GET using AJAX with HTML response
     *
     * @param url URL
     * @param $responseCont Response container jQuery object
     * @param callBackFn Callback function
     */
    Inventory.AJAX.retrieve = function (url, $responseCont, callBackFn) {

        // Init request
        initRequest($responseCont, callBackFn);

        $.ajax({
            url: url,
        }).done(function (response) {
            // Show response
            $responseContainer.html(response);

            // Perform callback
            callBack();

            // Eval JS in response
            let text = response.match(/<script>.*<\/script>/gu);

            if (text) {
                $.each(text, function (index, value) {
                    // Remove tags
                    value = value.replace('<script>', '');
                    value = value.replace('</script>', '');

                    // Execute code
                    eval(value);
                });
            }
        });
    };

    /**
     * HTTP GET using AJAX with JSON response
     *
     * @param url URL
     * @param $responseCont Response container ID
     * @param callBackFn Callback function
     */
    Inventory.AJAX.execute = function (url, $responseCont, callBackFn) {

        // Init request
        initRequest($responseCont, callBackFn);

        $.ajax({
            url: url,
        }).done(function (response) {
            parseResponse(response);

            // If positive response --> perform callback
            if (responseFlag === 'pos') {
                callBack();
            }
        });
    };

    return Inventory;
}(Inventory || {}, jQuery));
