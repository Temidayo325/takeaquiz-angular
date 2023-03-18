import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Subject, Observable, of } from 'rxjs';
import { map, catchError } from 'rxjs/operators';
import { StoreService } from './../service/store.service';

@Injectable({
  providedIn: 'root'
})
export class QuestionService {
     // public baseUrl =  'http://127.0.0.1:8000';
     token: string = this.store.getToken().slice(1,-1)
     public baseUrl = "https://quizly-api.luminaace.com/api/";
     public options = {
          headers : new HttpHeaders({
               'Content-Type': 'application/json',
               'Accept': 'application/json',
               'Authorization': 'Bearer '+ this.token,
          }),
     }


     public form = {
          headers: new HttpHeaders({
               // 'Content-Type': 'multipart/form-data',
               'Accept': 'application/json',
               'Authorization': 'Bearer '+ this.token,
          })
     }
     constructor(
          private http: HttpClient,
          private store: StoreService,
     ) { }

     createFromForm(question: object): Observable<any>
     {
       return this.http.post(this.baseUrl+"question", question, this.options )
     }

     createFromFile(question: File, topic_id: any, data: object):Observable<any>
     {
          const file:File = question;
          const formData = new FormData();

          formData.append("question", file);
          formData.append("topic_id", topic_id);

            // const upload$ = this.http.post("/api/thumbnail-upload", formData);
          return this.http.post(this.baseUrl+"importquestion", formData, this.form )
     }
}
