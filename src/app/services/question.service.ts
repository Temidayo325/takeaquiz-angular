import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Subject, Observable, of } from 'rxjs';
import { map, catchError } from 'rxjs/operators';
import { StoreService } from './../service/store.service';

@Injectable({
  providedIn: 'root'
})
export class QuestionService {
     public baseUrl = "https://quizly-api.luminaace.com/api/";
     public options = {
          headers : new HttpHeaders({
               'Content-Type': 'application/json',
               'Accept': 'application/json',
               'Authorization': 'Bearer '+ this.store.token,
          }),
     }
     constructor(
          private http: HttpClient,
          private store: StoreService,
     ) { }

     createFromForm(question: object): Observable<any>
     {
       return this.http.post(this.baseUrl+"question", question, this.options )
     }

     createFromFile(question: File, topic_id: number):Observable<any>
     {
          return this.http.post(this.baseUrl+"topics", question, this.options )
     }
}
