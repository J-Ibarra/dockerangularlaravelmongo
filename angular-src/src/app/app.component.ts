import {Component, OnInit} from "@angular/core";
import {ApiService} from "./api.service";

@Component({
    selector: 'app-root',
    template: `
        <h1>
            {{title}}
        </h1>
        
        <hr>

        <div *ngIf="data">
            <h3>
                <pre>{{data | json}}</pre>
            </h3>
        </div>

        <div *ngIf="err">
            <h3>
                <pre>{{err}}</pre>
            </h3>
        </div>
        
        <hr>
    `,
    styles: [`
    
    `]
})
export class AppComponent implements OnInit {

    title;
    data;
    err;

    constructor(private apiService: ApiService) {

    }

    ngOnInit(): void {
        this.title = 'App works!';

        this.apiService.get().subscribe(
            data => {
                this.data = data;
            },
            err => {
                this.err = err;
            }
        );
    }


}
