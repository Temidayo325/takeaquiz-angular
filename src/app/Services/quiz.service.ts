import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class QuizService {

  constructor(
        private http: HttpClient,
 ) { }

 // public baseUrl = "https://takeaquiz.luminaace.com/api/v1/";
 public baseUrl = " http://127.0.0.1:8000/api/v1/";
 public options = {
      headers : new HttpHeaders({
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            // 'Access-Control-Allow-Origin': '*',
      }),
  }

  public submitTest(details: {}):Observable<any>
  {
       return this.http.post(this.baseUrl+'test', details, this.options )
  }
}
