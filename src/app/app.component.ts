import { Component,OnInit  } from '@angular/core';
import {Title} from '@angular/platform-browser';
import { Observable } from 'rxjs';
import { NgForm } from '@angular/forms';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
     loggedInUser!: Observable<any>
     constructor(
          private htitle: Title,
     ){

     }
     title = 'quizly-ng'

     ngOnInit(): void {
          //Called after the constructor, initializing input properties, and the first call to ngOnChanges.
          //Add 'implements OnInit' to the class.
          this.htitle.setTitle("quizly-ng")
          // this.loggedInUser = this.store.select((store) => store.user);
     }
}
