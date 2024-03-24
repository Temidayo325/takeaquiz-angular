import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { StoreService } from './store.service';
import {CourseService } from './course.service';
import { QuestionModel } from './../models/QuestionModel';

@Injectable({
  providedIn: 'root'
})
export class QuestionsService {

  constructor(
       private store: StoreService,
       private course: CourseService,
       private http: HttpClient,
 ) { }
      public baseUrl = "https://takeaquiz.aeesdamilola.com/api/v1/"
      // public baseUrl = " http://127.0.0.1:8000/api/v1/";
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

     typedcoursesAndQuestions(type: string): Observable<any>
     {
          return this.http.get(this.baseUrl+`typedCourse/${type}`, this.options )
     }
     germanCoursesAndQuestions():Observable<any>
     {
          return this.http.get(this.baseUrl+`germanCourseQuestion`, this.options )
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
     // German question starts here
     addGermanQuestion(question: object): Observable<any>
     {
          return this.http.post(this.baseUrl+"germanQuestion", question, this.options )
     }
     // ==== Essay question type =======
     addEssayQuestion(question: QuestionModel): Observable<any>
     {
          return this.http.post(this.baseUrl+"essay_question", question, this.options )
     }
     // ===== Essay ends here ========
}
