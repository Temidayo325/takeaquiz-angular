import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { StoreService } from './store.service';

@Injectable({
  providedIn: 'root'
})
export class TrueorfalseService {

  constructor(
       private store: StoreService,
       private http: HttpClient,
  ) { }
      public baseUrl = " http://127.0.0.1:8000/api/v1/";
      // public baseUrl = "https://takeaquiz.luminaace.com/api/v1/"
      public token: string = this.store.getToken()
      private options = {
          headers : new HttpHeaders({
               'Content-Type': 'application/json',
               'Accept': 'application/json',
               // 'Access-Control-Allow-Origin': '*',
               'Authorization': "Bearer "+this.token
          }),
     }
     public getCount(): Observable<any>
     {
          return this.http.get(this.baseUrl+"countQuestion", this.options )
     }
     public coursesAndQuestions(): Observable<any>
     {
        return this.http.get(this.baseUrl+`booleanCourseQuestion`, this.options )
     }
     public addQuestions(details: object): Observable<any>
     {
        return this.http.post(this.baseUrl+`booleanQuestion`, details, this.options )
     }
     public updateQuestions(details: object): Observable<any>
     {
        return this.http.put(this.baseUrl+`booleanQuestion`, details, this.options )
     }
     public deleteQuestions(details: any, display_token: string): Observable<any>
     {
        return this.http.delete(this.baseUrl+`booleanQuestion?id=${details.id}&display_token=${display_token}&mark=${details.mark}&answer=${details.answer}&question=${details.question}`, this.options )
     }
     public editQuestions(details: object): Observable<any>
     {
        return this.http.patch(this.baseUrl+`booleanQuestion`, details, this.options )
     }
}
