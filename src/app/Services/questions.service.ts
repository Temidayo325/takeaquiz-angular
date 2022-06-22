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
      public baseUrl = "https://takeaquiz.luminaace.com/api/v1/"
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
     editQuestion(question: object): Observable<any>
     {
          return this.http.patch(this.baseUrl+"question", question, this.options )
     }

     addQuestion(question: object): Observable<any>
     {
          return this.http.post(this.baseUrl+"question", question, this.options )
     }
     deleteQuestion(display_token: string, id: number)
     {
          return this.http.delete(this.baseUrl+`question?display_token=${display_token}&id=${id}`, this.options )
     }
}
