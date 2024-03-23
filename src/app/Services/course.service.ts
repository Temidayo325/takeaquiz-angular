import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { StoreService } from './store.service';

@Injectable({
  providedIn: 'root'
})
export class CourseService  {

      constructor(
            private http: HttpClient,
            private store: StoreService
      ){ }
     public baseUrl = "https://takeaquiz.aeesdamilola.com/api/v1/";
     // public baseUrl = " http://127.0.0.1:8000/api/v1/";
     public token: string = this.store.getToken()
     options = {
         headers : new HttpHeaders({
               'Content-Type': 'application/json',
               'Accept': 'application/json',
               'Authorization': "Bearer "+this.token
         }),
     }
     dowload = {
          headers : new HttpHeaders({
               'responseType': 'arrayBuffer',
               'observe': 'response',
               'Content-Disposition': 'attachment; filename="thetestresult.csv',
               'X-Content-Type-Options': 'nosniff',
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
     getTyped(type: string):Observable<any>
     {
          return this.http.get(this.baseUrl+`typedCourse/${type}`, this.options )
     }
     getTheory():Observable<any>
     {
          return this.http.get(this.baseUrl+"theoryCourse", this.options )
     }

     deleteCourse(course: {}):Observable<any>
     {
          return this.http.put(this.baseUrl+"course", course , this.options )
     }

     editCourse(course: object):Observable<any>
     {
          return this.http.patch(this.baseUrl+"course", course , this.options )
     }

     download(course: object):Observable<any>
     {
          // console.log(this.token)
          return this.http.post(this.baseUrl+"result", course, this.options)
          // window.open(`/result?display_token=${course}`)
     }

     createCa(course: object): Observable<any>
     {
          return this.http.post(this.baseUrl+"assesment", course, this.options )
     }

     toggleCaStatus(details: object): Observable<any>
     {
          return this.http.patch(this.baseUrl+"assesment", details, this.options )
     }
}
