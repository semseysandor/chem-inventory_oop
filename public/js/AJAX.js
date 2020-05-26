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
     * Params for callback function
     */
    let callBackParams;

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
     * @param callBackParameters Callback fn parameters
     */
    function initRequest(responseContainer, callBackFn, callBackParameters)
    {
        $responseContainer = $(responseContainer);
        callBack = null;
        callBackParams = [];
        responseFlag = null;
        responseText = null;

        if ($.isFunction(callBackFn)) {
            // Set callback
            callBack = callBackFn;
            // Put callback arguments
            callBackParams = callBackParameters;
        }
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
     * Performs callback
     */
    function performCallBack()
    {
        if ($.isFunction(callBack)) {
            callBack(...callBackParams);
        }
    }

    /**
     * Submit form using AJAX with JSON response
     *
     * @param form Form element
     * @param responseContainer Form response container
     * @param callBackFn Callback function
     * @param callBackParameters Callback fn parameters
     */
    Inventory.AJAX.submit = function (form, responseContainer, callBackFn, callBackParameters) {

        let $form = $(form);

        // Init request
        initRequest(responseContainer, callBackFn, callBackParameters);

        $.ajax({
            url: $form.attr('action'),
            data: $form.serialize(),
            type: $form.attr('method'),
            dataType: 'json',
        }).done(
            function (response) {
                // Clear responseContainer
                $responseContainer.html('');

                // Parse response
                responseFlag = response.flag;
                responseText = response.text;

                // Show response
                $responseContainer.html(Inventory.messageHTML(responseText, responseFlag));

                // If positive response
                if (responseFlag === 'pos') {
                    resetForm($form);
                    performCallBack();
                }
            },
        );
    };

    /**
     * HTTP GET using AJAX with HTML response
     *
     * @param url URL
     * @param responseContainer Response container
     * @param callBackFn Callback function
     * @param callBackParameters Callback fn parameters
     */
    Inventory.AJAX.retrieve = function (url, responseContainer, callBackFn, callBackParameters) {

        // Init request
        initRequest(responseContainer, callBackFn, callBackParameters);

        $.ajax({
            url: url,
        }).done(function (response) {
            // Show response
            $responseContainer.html(response);

            performCallBack();

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
     * @param responseID Response container ID
     * @param callBackFn Callback function
     * @param callBackParameters Callback fn parameters
     */
    Inventory.AJAX.execute = function (url, responseID, callBackFn, callBackParameters) {

        // Init request
        initRequest(responseID, callBackFn, callBackParameters);

        $.ajax({
            url: url,
        }).done(function (response) {
            // Clear responseContainer
            $responseContainer.html('');

            // Parse response
            responseFlag = response.flag;
            responseText = response.text;

            // Show response
            $responseContainer.html(Inventory.messageHTML(responseText, responseFlag));

            // If positive response
            if (responseFlag === 'pos') {
                performCallBack();
            }
        });
    };

    return Inventory;
}(Inventory || {}, $));
