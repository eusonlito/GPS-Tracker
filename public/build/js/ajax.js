'use strict';

class Ajax {
    constructor(url, method) {
        this.setUrl(url);
        this.setMethod(method);
        this.setBody();
        this.setCallback();
        this.setCallbackParameters();
        this.setError();
        this.setHeaders();
        this.setJson(true);

        return this;
    }

    setMethod(method) {
        this.method = method || 'GET';

        return this;
    }

    setUrl(url) {
        this.url = url;

        return this;
    }

    setHeaders(headers) {
        this.headers = headers || {};

        return this;
    }

    setAjax(ajax) {
        if (ajax) {
            this.headers['X-Requested-With'] = 'XMLHttpRequest';
        } else {
            delete this.headers['X-Requested-With'];
        }

        return this;
    }

    setJson(json) {
        this.json = json;

        if (json) {
            this.headers['Content-Type'] = 'application/json';
        } else {
            delete this.headers['Content-Type'];
        }

        this.setJsonResponse(json);

        return this;
    }

    setJsonResponse(jsonResponse) {
        this.jsonResponse = jsonResponse;

        if (jsonResponse) {
            this.headers['Accept'] = 'application/json';
        } else {
            delete this.headers['Accept'];
        }

        return this;
    }

    setBody(body) {
        this.body = body;

        return this;
    }

    setBodyForm(form) {
        this.form = form;

        return this;
    }

    setCallback(callback) {
        this.callback = callback || function () { };

        return this;
    }

    setCallbackParameters(parameters) {
        this.callbackParameters = parameters || {};

        return this;
    }

    setError(error) {
        this.error = error || function (message) { console.error(message) };

        return this;
    }

    send() {
        return fetch(this.url, this.sendData()).then(async response => {
            response = await this.sendResponse(response);

            if (typeof response === 'undefined') {
                return;
            }

            this.callback(response, this.body, this.callbackParameters);

            if (!this.jsonResponse) {
                document.dispatchEvent(new Event('ajax'));
            }
        }).catch(error => this.error(error));
    }

    sendData() {
        return {
            method: this.method,
            headers: this.headers,
            body: this.sendBody()
        };
    }

    sendBody() {
        if (this.form) {
            return this.sendBodyForm();
        }

        if (this.body) {
            return this.sendBodyJson();
        }

        return null;
    }

    sendBodyJson() {
        this.headers['Content-Type'] = 'application/json';

        return JSON.stringify(this.body);
    }

    sendBodyForm() {
        return new URLSearchParams(new FormData(this.form));
    }

    async sendResponse(response) {
        const text = await response.text();

        if (this.jsonResponse) {
            return this.sendResponseJson(response, text);
        }

        return this.sendResponseHtml(response, text);
    }

    sendResponseJson(response, text) {
        let data;

        try {
            data = JSON.parse(text);
        } catch (error) {
            return this.error(error);
        }

        if (!response.ok) {
            return this.error(data.message);
        }

        return data;
    }

    sendResponseHtml(response, text) {
        if (!response.ok) {
            return this.error(text);
        }

        return text;
    }
};
