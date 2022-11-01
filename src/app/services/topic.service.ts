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

     create(topic: Topic): Observable<any>
     {
       return this.http.post(this.baseUrl+"topics", topic, this.options )
     }

     get(): Observable<any>
     {
          return this.http.get(this.baseUrl+"topics", this.options)
     }

     delete(id: number): Observable<any>
     {
          return this.http.delete(this.baseUrl+"topics/"+id, this.options)
     }
}
