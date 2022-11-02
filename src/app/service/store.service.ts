import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class StoreService {

  constructor() { }
  public user: any;
  public token = sessionStorage.getItem('token');
  public questions = JSON.parse(sessionStorage.getItem('questions')!) ;
  public topics = JSON.parse(sessionStorage.getItem('topics')!);

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

  setAdmin(questions: Array<any>, topics: Array<any>)
  {
       sessionStorage.setItem('questions', JSON.stringify(questions))
       sessionStorage.setItem('topics', JSON.stringify(topics))
  }

  setTopics(topics: Array<any>)
  {
       sessionStorage.setItem('topics', JSON.stringify(topics));
  }

  getToken():string
  {
       return this.token!
  }

  logout():void
  {
       this.token = ''
       this.user = ''
       sessionStorage.clear()
  }
}
