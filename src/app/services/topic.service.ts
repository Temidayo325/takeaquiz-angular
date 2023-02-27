 import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Subject, Observable, of } from 'rxjs';
import { map, catchError } from 'rxjs/operators';
import { Topic } from './../models/topic.models';
import { StoreService } from './../service/store.service';

@Injectable({
  providedIn: 'root'
})
export class TopicService {

     // public baseUrl =  'http://127.0.0.1:8000';
  public token: string = ''

  public baseUrl = "https://quizly-api.luminaace.com/api/";
  public options: Object = {}

       constructor(
            private http: HttpClient,
            private store: StoreService,
      ) {
           if (this.store.getToken() !== null) {
               this.token = this.store.getToken().slice(1,this.store.getToken().length - 1)
               this.options = {
                    headers : new HttpHeaders({
                         'Content-Type': 'application/json',
                         'Accept': 'application/json',
                         'Authorization': 'Bearer '+ this.token,
                    }),
               }
           }
      }

     create(topic: Topic): Observable<any>
     {
       return this.http.post(this.baseUrl+"topics", topic, this.options )
     }

     get(): Observable<any>
     {
          return this.http.get(this.baseUrl+"topics", this.options)
     }

     publicGet(): Observable<any>
     {
          let guest = {
               headers : new HttpHeaders({
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer '+ this.token,
               }),
          }
          return this.http.get(this.baseUrl+"public/topics", guest)
     }
     delete(id: number): Observable<any>
     {
          return this.http.delete(this.baseUrl+"topics/"+id, this.options)
     }

     getbyId(id: number): Observable<any>
     {
          return this.http.get(this.baseUrl+"topics/"+id, this.options)
     }

     activateQuestion(question_id: number): Observable<any>
     {
          return this.http.patch(this.baseUrl+"question/"+question_id, {question_id: question_id},this.options)
     }

     editQuestion(question: object): Observable<any>
     {
          return this.http.patch(this.baseUrl+"question", question ,this.options)
     }

     shareAssessment(id$: number):Observable<unknown>
     {
          return this.http.post(this.baseUrl+"share/generate-code", {topic_id: id$}, this.options)
     }
}
