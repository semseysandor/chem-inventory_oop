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
(function (Inventory) {
    'use strict';

    /**
     * HTTP request
     *
     * @type {XMLHttpRequest}
     */
    let request = new XMLHttpRequest();

    /**
     * Form
     */
    let form;

    /**
     * Container for response from AJAX
     */
    let responseContainer;

    /**
     * Form data
     */
    let data;

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

    Inventory.AJAX = {};

    /**
     * Set cursor to default
     */
    function setCursorDefault()
    {
        // Set cursor back to default
        if (request.readyState === 4) {
            document.body.style.cursor = 'auto';
        }
    }

    /**
     * Set cursor to progress indicator
     */
    function setCursorProgress()
    {
        document.body.style.cursor = 'progress';
    }

    /**
     * Collect data from form
     */
    function collectData()
    {
        // Collect the form data while iterating over form elements
        Object.keys(form).forEach(function (i) {
            // Only if element has name
            if (form[i].name !== '') {
                // If checkbox
                if (form[i].type === 'checkbox') {
                    if (form[i].checked) {
                        data[form[i].name] = form[i].value;
                    }
                } else {
                    data[form[i].name] = form[i].value;
                }
            }
        });
    }

    /**
     * Reset form fields
     */
    function resetForm()
    {
        Object.keys(form).forEach(function (i) {
            // Don't clear hidden inputs
            if (form[i].type !== 'hidden') {
                form[i].value = '';
            }
        });
    }

    /**
     * Parse JSON response
     */
    function parseResponse()
    {
        let responseObj;

        // Parse JSON
        try {
            responseObj = JSON.parse(request.responseText);
        } catch (ex) {
            responseText = request.responseText;
            return;
        }

        // Set response flag
        if (responseObj.hasOwnProperty('flag')) {
            responseFlag = responseObj.flag;
        } else {
            responseFlag = null;
        }

        // Set response text
        if (responseObj.hasOwnProperty('text')) {
            responseText = responseObj.text;
        } else {
            responseText = null;
        }
    }

    /**
     * Performs callback
     */
    function performCallBack()
    {
        if (typeof callBack === 'function') {
            callBack(...callBackParams);
        }
    }

    /**
     * Encode data to JSON
     */
    function encodeJSON()
    {
        // Data object to JSON
        data = JSON.stringify(data);
        // URL encode
        data = encodeURI(data);
    }

    /**
     * Init request
     *
     * @param responseID Response container ID
     * @param callBackFn Callback function
     * @param callBackParameters Callback fn parameters
     */
    function initRequest(responseID, callBackFn, callBackParameters)
    {
        responseContainer = document.getElementById(responseID);
        callBack = null;
        callBackParams = [];

        // Put all parameters for callback in an array (if available)
        if (typeof callBackFn === 'function') {
            callBack = callBackFn;
            callBackParameters.forEach(function (value, index) {
                callBackParams[index] = value;
            });
        }
    }

    /**
     * Init AJAX form submit request
     *
     * @param formID Form ID
     * @param formResponseID Form response ID
     * @param callBackFn Callback function
     * @param callBackParameters Callback function parameters
     */
    function initSubmit(formID, formResponseID, callBackFn, callBackParameters)
    {
        // Init request
        initRequest(formResponseID, callBackFn, callBackParameters);

        // Init submit properties
        form = document.getElementById(formID);
        data = {};
        responseFlag = null;
        responseText = null;
    }

    /**
     * Submit form using AJAX with JSON response
     *
     * @param formID Form ID
     * @param formResponseID Form response ID
     * @param callBackFn Callback function
     * @param callBackParameters Callback fn parameters
     */
    Inventory.AJAX.submit = function (formID, formResponseID, callBackFn, callBackParameters) {

        // Set cursor for progress
        setCursorProgress();

        // Init request
        initSubmit(formID, formResponseID, callBackFn, callBackParameters);

        // Collect data from form
        collectData();

        // Encode data to JSON
        encodeJSON();

        // Send request
        request.open(form.method, form.action, true);
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        request.send('data=' + data);

        // When response ready
        request.onreadystatechange = function () {

            // Set cursor back to default
            setCursorDefault();

            // When response is ready from server
            if ((request.readyState === 4) && (request.status === 200)) {
                // Clear responseContainer
                responseContainer.innerHTML = '';

                // Parse response
                parseResponse();
                // If successful
                if (responseFlag === 'pos') {
                    resetForm();

                    // Perform callback
                    performCallBack();
                }

                // Show response
                responseContainer.innerHTML = Inventory.messageHTML(responseText, responseFlag);
            }
        };
    };

    /**
     * HTTP GET using AJAX with HTML response
     *
     * @param url URL
     * @param responseID Response container ID
     * @param callBackFn Callback function
     * @param callBackParameters Callback fn parameters
     */
    Inventory.AJAX.retrieve = function (url, responseID, callBackFn, callBackParameters) {

        // Init request
        initRequest(responseID, callBackFn, callBackParameters);

        // Send request
        request.open('GET', url, true);
        request.send();

        setCursorProgress();

        // When request ready
        request.onreadystatechange = function () {

            setCursorDefault();

            if ((request.readyState === 4) && (request.status === 200)) {
                // Show response
                responseContainer.innerHTML = request.responseText;

                performCallBack();
            }
        };
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

        // Send request
        request.open('GET', url, true);
        request.send();

        // Set cursor for progress
        setCursorProgress();

        // When response ready
        request.onreadystatechange = function () {

            // Set cursor back to default
            setCursorDefault();

            // When response is ready from server
            if ((request.readyState === 4) && (request.status === 200)) {
                // Clear responseContainer
                responseContainer.innerHTML = '';

                // Parse response
                parseResponse();

                // If successful
                if (responseFlag === 'pos') {
                    // Perform callback
                    performCallBack();
                }

                // Show response
                responseContainer.innerHTML = Inventory.messageHTML(responseText, responseFlag);
            }
        };
    };

    return Inventory;
}(Inventory || {}));
