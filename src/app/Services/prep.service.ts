import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { ComplaintService } from './complaint.service';

@Injectable({
  providedIn: 'root'
})
export class PrepService {

  constructor(
        private http: HttpClient,
        private complaint: ComplaintService
 ) { }

     public baseUrl = "http://127.0.0.1:8000/api/v1/";
     public questions: any = []
     public details: any = {display_token: '', matric: '', timer: 0}
     public options = {
          headers : new HttpHeaders({
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                // 'Access-Control-Allow-Origin': '*',
          }),
     }

     get(display_token: string, matric: string):Observable<any>
     {
          return this.http.get(this.baseUrl+`test?display_token=${display_token}&matric=${matric}`, this.options )
     }

     store(questions: [], time: number, display_token: string, matric: string)
     {
          this.questions = questions
          this.details.timer = time
          this.details.matric = matric
          this.details.display_token = display_token
     }

     postComplaint(details: any):Observable<any>
     {
          return this.complaint.sendCompaint(details);
     }

     retrieveQuestions()
     {
          return this.questions
     }

     getDetails()
     {
          return this.details
     }
}
