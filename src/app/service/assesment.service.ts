import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Subject, Observable, of } from 'rxjs';
import { map, catchError } from 'rxjs/operators';
import { Result } from './../models/uploadrresult.models';
import { StoreService } from './../service/store.service';

@Injectable({
  providedIn: 'root'
})
export class AssesmentService {

  constructor(
       private http: HttpClient,
       private store: StoreService
  ) { }

  // public baseUrl = "https://quizly-api.luminaace.com/api/";
     public baseUrl = "https://quizly.aeesdamilola.com/api/";
     public token: string = this.store.getToken().substring(1,this.store.getToken().length - 1)
     public user = JSON.parse(sessionStorage.getItem('user')!)

  options = {
       headers : new HttpHeaders({
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': 'Bearer '+ this.token
            // 'Access-Control-Allow-Origin': 'http://127.0.0.1:8000',
       }),
  }
  guest = {
       headers : new HttpHeaders({
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            // 'Access-Control-Allow-Origin': 'http://127.0.0.1:8000',
       }),
  }
  requestAssesment(topic_id: number): Observable<any>
  {
       console.log(topic_id)
    return this.http.post(this.baseUrl+`start-quiz`, {topic_id: topic_id, proffessional_status: ( this.user.is_proffessional  == 1 ) ? true : false}, this.options )
  }

  submitAssesment(data: Result): Observable<any>
  {
       return this.http.post(this.baseUrl+'quiz', data, this.options )
  }

  GetSharedAssessmentResult(code$: string):Observable<unknown>
  {
      return this.http.post(this.baseUrl+`share/result/${code$}`, {code: code$}, this.guest)
  }

  countTotalQuestion(id: number): Observable<unknown>
  {
       return this.http.post(this.baseUrl+"content/show", {topic_id: id}, this.options)
  }
}
