import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { StoreService } from './store.service';

import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ComplaintService {

  constructor(
       private http: HttpClient,
       private store: StoreService
 ) { }
  public options = {
       headers : new HttpHeaders({
             'Content-Type': 'application/json',
             'Accept': 'application/json',
             'Authorization': 'Bearer '+ this.store.token
             // 'Access-Control-Allow-Origin': '*',
       }),
  }
  // public baseUrl = "https://takeaquiz.luminaace.com/api/v1/";
  public baseUrl = " http://127.0.0.1:8000/api/v1/";
  
  public sendCompaint(details: any):Observable<any>
  {
       return this.http.post(this.baseUrl+'complaints', details, this.options )
  }
  public getLastComplaint():Observable<any>
  {
      return this.http.get(this.baseUrl+'lastComplaint', this.options )
  }
  public getActiveComplaints(): Observable<any>
  {
       return this.http.get(this.baseUrl+'activeComplaint', this.options )
  }
  public deactivate(id: any): Observable<any>
  {
      return this.http.patch(this.baseUrl+'activeComplaint', id,this.options )
  }
}
