import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Subject, Observable, of } from 'rxjs';
import { map, catchError } from 'rxjs/operators';
import { Result } from './../models/uploadrresult.models';

@Injectable({
  providedIn: 'root'
})
export class AssesmentService {

  constructor(
       private http: HttpClient
  ) { }
  public baseUrl = "https://quizly-api.luminaace.com/api/";
  public token: string = sessionStorage.getItem('token')!

  options = {
       headers : new HttpHeaders({
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': 'Bearer '+ this.token
            // 'Access-Control-Allow-Origin': 'http://127.0.0.1:8000',
       }),
  }

  requestAssesment(topic_id: number): Observable<any>
  {
    return this.http.get(this.baseUrl+`quiz?topic_id=`+topic_id, this.options )
  }

  submitAssesment(data: Result): Observable<any>
  {
       return this.http.post(this.baseUrl+'quiz', data, this.options )
  }
}
