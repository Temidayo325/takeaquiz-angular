import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { StoreService } from './store.service';

@Injectable({
  providedIn: 'root'
})
export class StudentService {

    constructor(
       private http: HttpClient,
       private store: StoreService
    ) { }
    // public baseUrl = " http://127.0.0.1:8000/api/v1/";
    public baseUrl = "https://takeaquiz.aeesdamilola.com/api/v1/"
    public token: string = this.store.getToken()
    private options = {
        headers : new HttpHeaders({
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              // 'Access-Control-Allow-Origin': '*',
              'Authorization': "Bearer "+this.token
        }),
   }

   countCourseStudent(): Observable<any>
   {
        return this.http.get(this.baseUrl+"courseStudent", this.options )
   }
   searchStudent(course: string, matric: string): Observable<any>
   {
        return this.http.get(this.baseUrl+`student?course=${course}&matric=${matric}`, this.options )
   }
   deleteStudent(course: string, matric: string): Observable<any>
   {
         return this.http.delete(this.baseUrl+`student?course=${course}&matric=${matric}`, this.options )
   }
}
