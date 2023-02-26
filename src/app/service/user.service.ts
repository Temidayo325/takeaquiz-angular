import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Subject, Observable, of } from 'rxjs';
import { map, catchError } from 'rxjs/operators';
import { Login } from './../models/login.models';
import { NewUser } from './../models/newUser.models';
import { Profile } from './../models/newUser.models';
import { StoreService } from './store.service';

@Injectable({
  providedIn: 'root'
})
export class UserService {
     public baseUrl = "https://quizly-api.luminaace.com/api/";
     // public baseUrl =  'http://127.0.0.1:8000';
     constructor(
            private http: HttpClient,
            private storeService: StoreService
      ){}
 options = {
      headers : new HttpHeaders({
           'Content-Type': 'application/json',
           'Accept': 'application/json',
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
       return this.http.patch(this.baseUrl+"resendVerification", email, this.options )
  }

  changeUserPassword(user: object): Observable<any>
  {
       return this.http.put(this.baseUrl+"resetPassword", user, this.options )
  }

  getResults(id: number): Observable<any>
  {
       let token: string = this.storeService.getToken().slice(1,-1)
       // this.options.headers.append('Authorization', `Bearer ${token}`)
      let options = {
            headers : new HttpHeaders({
                 'Content-Type': 'application/json',
                 'Accept': 'application/json',
                 'Authorization': 'Bearer '+token
            }),
       }
       return this.http.get(this.baseUrl+`result?user_id=${id}`, options )
  }

  resendVerificationCode(email: string): Observable<any>
  {
      return this.http.post(this.baseUrl+"resendVerification", {email: email},this.options)
  }

  logout(user_id: number): Observable<any>
  {
      return this.http.post(this.baseUrl+"logout", {user_id: user_id},this.options)
  }

  updateProfile(profile: Profile): Observable<any>
  {
       let token: string = this.storeService.getToken().slice(1,-1)
       // this.options.headers.append('Authorization', `Bearer ${token}`)
      let options = {
            headers : new HttpHeaders({
                 'Content-Type': 'application/json',
                 'Accept': 'application/json',
                 'Authorization': 'Bearer '+token
            }),
       }
      // console.log(this.storeService.getToken(), token)
       return this.http.post(this.baseUrl+"profile/edit", profile, options )
  }
}
