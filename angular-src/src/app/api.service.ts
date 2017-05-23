import {Injectable} from "@angular/core";
import {Headers, Http} from "@angular/http";

import "rxjs/add/operator/map";

@Injectable()
export class ApiService {

    constructor(private http: Http) {
    }

    get() {
        const headers = new Headers();
        const ep = '/api/v1.0';
        headers.append('Content-Type', 'application/json');

        return this.http.get(ep, {headers: headers})
            .map(res => res.json());
    }

}
