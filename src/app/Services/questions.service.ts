import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { StoreService } from './store.service';
import {CourseService } from './course.service';

@Injectable({
  providedIn: 'root'
})
export class QuestionsService {

  constructor(
       private store: StoreService,
       private course: CourseService,
       private http: HttpClient,
 ) { }
      public baseUrl = "http://127.0.0.1:8000/api/v1/"
      public token: string = this.store.getToken()
      private options = {
          headers : new HttpHeaders({
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                // 'Access-Control-Allow-Origin': '*',
                'Authorization': "Bearer "+this.token
          }),
     }
     getCount(): Observable<any>
     {
          return this.http.get(this.baseUrl+"countQuestion", this.options )
     }

     coursesAndQuestions(): Observable<any>
     {
          return this.http.get(this.baseUrl+"courseQuestion", this.options )
     }
     editQuestion()
     {

     }

     addQuestion(question: object): Observable<any>
     {
          return this.http.post(this.baseUrl+"question", question, this.options )
     }
}
