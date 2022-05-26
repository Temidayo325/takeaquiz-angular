import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class UserService {
     public baseUrl = "http://127.0.0.1:8000/api/v1/";
     // public headers = {'Content-Type': 'application/json' , 'Accept': 'application/json'};

  constructor(
       private http: HttpClient
 ) { }
 options = {
      headers : new HttpHeaders({
           'Content-Type': 'application/json',
           'Accept': 'application/json'
      }),
 }
  login(user: object): Observable<any>
  {
    return this.http.put(this.baseUrl+"users", user, this.options )
  }

  register(user: object): Observable<any>
  {
       return this.http.post(this.baseUrl+"users", user, this.options )
  }

  verifyAccount(user: object): Observable<any>
  {
       return this.http.put(this.baseUrl+"verify-password", user, this.options )
  }

  recoverEmail(email: any):Observable<any>
  {
       return this.http.patch(this.baseUrl+"reset-password", email, this.options )
  }

  changeUserPassword(user: object): Observable<any>
  {
       return this.http.put(this.baseUrl+"reset-password", user, this.options )
  }
}
