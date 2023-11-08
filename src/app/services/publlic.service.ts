import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Subject, Observable, of } from 'rxjs';
import { map, catchError } from 'rxjs/operators';



@Injectable({
  providedIn: 'root'
})
export class PubllicService {

  constructor(
       private http: HttpClient
 ) { }
  // public baseUrl = "https://quizly-api.luminaace.com/api/";
  public baseUrl = "https://quizly.aeesdamilola.com/api/";

  domainStat(): Observable<any>
  {
       return this.http.get("https://quizly.aeesdamilola.com/api/public/stats");
  }
}
