import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { StoreService } from './store.service';

@Injectable({
  providedIn: 'root'
})
export class CourseService {

      constructor(
            private http: HttpClient,
            private store: StoreService
      ){ }
     public baseUrl = "http://127.0.0.1:8000/api/v1/";
     public token: string = this.store.getToken()
     options = {
         headers : new HttpHeaders({
               'Content-Type': 'application/json',
               'Accept': 'application/json',
               // 'Access-Control-Allow-Origin': '*',
               'Authorization': "Bearer "+this.token
         }),
     }

     create(course: object): Observable<any>
     {
          return this.http.post(this.baseUrl+"course", course, this.options )
     }

     get():Observable<any>
     {
          return this.http.get(this.baseUrl+"course", this.options )
     }

     deleteCourse(course: {}):Observable<any>
     {
          return this.http.put(this.baseUrl+"course", course , this.options )
     }

     editCourse(course: object):Observable<any>
     {
          return this.http.patch(this.baseUrl+"course", course , this.options )
     }

     download(course: any): Observable<any>
     {
          return this.http.get(this.baseUrl+"result?"+course , this.options )
     }
}
