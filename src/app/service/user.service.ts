import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Subject, Observable, of } from 'rxjs';
import { map, catchError } from 'rxjs/operators';
import { Login } from './../models/login.models';
import { NewUser } from './../models/newUser.models';

@Injectable({
  providedIn: 'root'
})
export class UserService {
     public baseUrl = "https://quizly-api.luminaace.com/api/";
     constructor(
            private http: HttpClient
      ){}
 options = {
      headers : new HttpHeaders({
           'Content-Type': 'application/json',
           'Accept': 'application/json',
           // 'Access-Control-Allow-Origin': 'http://127.0.0.1:8000',
      }),
 }
  login(user: Login): Observable<any>
  {
    return this.http.post(this.baseUrl+"login", user, this.options )
  }

  adminLogin(user: Login): Observable<any>
  {
    return this.http.post(this.baseUrl+"admin", user, this.options )
  }

  register(user: NewUser): Observable<any>
  {
       return this.http.post(this.baseUrl+"register", user, this.options )
  }

  verifyAccount(user: object): Observable<any>
  {
       return this.http.post(this.baseUrl+"verifyEmail", user, this.options )
  }

  recoverEmail(email: any):Observable<any>
  {
       return this.http.patch(this.baseUrl+"reset-password", email, this.options )
  }

  changeUserPassword(user: object): Observable<any>
  {
       return this.http.put(this.baseUrl+"reset-password", user, this.options )
  }

  getResults(id: number): Observable<any>
  {
       return this.http.get(this.baseUrl+`result?user_id=1`, this.options )
  }
  logout(user_id: number): Observable<any>
  {
      return this.http.post(this.baseUrl+"logout", {user_id: user_id},this.options)
  }
}
