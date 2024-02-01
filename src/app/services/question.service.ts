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
     // public baseUrl = "https://quizly-api.luminaace.com/api/";
     public baseUrl = "https://quizly.aeesdamilola.com/api/author/";
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

     createFromForm(question: object, audience: string): Observable<any>
     {
          let ending_url = (audience == 'proffessional' ) ? "pep/question": "question";
          return this.http.post(this.baseUrl+ending_url, question, this.options )
     }

     createFromFile(question: File, topic_id: any, data: object, audience: string):Observable<any>
     {
          const file:File = question;
          const formData = new FormData();

          formData.append("question", file);
          formData.append("topic_id", topic_id);

          let ending_url = (audience == 'proffessional' ) ? "pep/importquestion": "importquestion";
          return this.http.post(this.baseUrl+ending_url, formData, this.form )
     }
}
