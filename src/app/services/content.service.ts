import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Subject, Observable, of } from 'rxjs';
import { map, catchError } from 'rxjs/operators';
import { Topic } from './../models/topic.models';
import { StoreService } from './../service/store.service';

@Injectable({
  providedIn: 'root'
})
export class ContentService {

  constructor(
       private http: HttpClient,
       private store: StoreService,
  ) { }
  private baseUrl: string = "https://quizly-api.luminaace.com/api/"
  private token: string = this.store.getToken().slice(1,this.store.getToken().length - 1)
  options: Object = {
       headers : new HttpHeaders({
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': 'Bearer '+ this.token,
       }),
  }

  public index(): Observable<any>
  {
       return this.http.get(this.baseUrl+"content", this.options)
  }

  public post(content: object): Observable<any>
  {
       return this.http.post(this.baseUrl+"content", content, this.options)
  }
}
