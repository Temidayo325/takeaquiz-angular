import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class StoreService {

  constructor() { }
  public user: any;
  public token = sessionStorage.getItem('token');

  getUser():Object
  {
       return this.user = JSON.parse(sessionStorage.getItem('user')!)
  }

  setuser(data: object, token: any)
  {
     sessionStorage.setItem('user', JSON.stringify(data))
     sessionStorage.setItem('token', token)
     this.token = token
     this.user = data
  }

  getToken():string
  {
       return this.token!
  }
}
