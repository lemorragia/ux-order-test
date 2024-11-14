import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    initialize() {
        this._onConnect = this._onConnect.bind(this);
    }

    connect() {
        this.element.addEventListener('autocomplete:connect', this._onConnect);
    }

    disconnect() {
        this.element.removeEventListener('autocomplete:connect', this._onConnect);
    }

    _onConnect(event) {
        document.addEventListener('tom-select:sync', function(){
            event.detail.tomSelect.sync()
        });
    }
}