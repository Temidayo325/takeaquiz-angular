import { Injectable } from '@angular/core';
import { UserRoles, Roles } from './../models/roles.model';

@Injectable({
  providedIn: 'root'
})
export class StoreService {

  constructor() { }
  public user: any;
  public token: string  = '';
  // public questions = JSON.parse(sessionStorage.getItem('questions')!) ;
  public topics: Array<any> = [];
  // public results = JSON.parse(sessionStorage.getItem('results')!);

  getQuestion(): string
  {
       return JSON.parse(sessionStorage.getItem('questions')!)
  }

  getTopics(): string
  {
       return JSON.parse(sessionStorage.getItem('topics')!)
  }

  getResults(): string
  {
       return JSON.parse(sessionStorage.getItem('results')!)
  }
  getUser():Object
  {
       return this.user = JSON.parse(sessionStorage.getItem('user')!)
  }
  resetUser(user: object):void
  {
     sessionStorage.setItem('user', JSON.stringify(user))
  }
  setuser(data: object, token: any): void
  {
       sessionStorage.setItem('user', JSON.stringify(data))
       sessionStorage.setItem('token', JSON.stringify(token))
       localStorage.setItem('token', token)
       this.token = token
       this.user = data
  }

  setAdmin(questions: Array<any>, topics: Array<any>): void
  {
       sessionStorage.setItem('questions', JSON.stringify(questions))
       sessionStorage.setItem('topics', JSON.stringify(topics))
  }

  setTopicAndResult(topics: any, results: Array<[]>):void
  {
       sessionStorage.setItem('topics', JSON.stringify(topics))
      sessionStorage.setItem('results', JSON.stringify(results))
  }

  setUserRoles(roles: Roles)
  {
        sessionStorage.setItem('roles', JSON.stringify(roles))
  }

  getUserRoles():UserRoles
  {
       let user_roles: Array<Roles> = JSON.parse(sessionStorage.getItem('roles')!);
       let possible_roles: UserRoles = {editor: false, admin: false, author: false};
       for(let role of user_roles)
       {
            if(role.role == 'admin')
            {
                 possible_roles.admin = true
            }

            if(role.role == 'editor')
            {
                 possible_roles.editor = true
            }
            if(role.role == 'author')
            {
                 possible_roles.author = true
            }
       }
       return possible_roles;
  }

  setTopics(topics: Array<any>)
  {
       sessionStorage.setItem('topics', JSON.stringify(topics));
  }

  getToken():string
  {
       return sessionStorage.getItem('token')!
  }

  logout():void
  {
       this.token = ''
       this.user = ''
       sessionStorage.clear()
  }
}
