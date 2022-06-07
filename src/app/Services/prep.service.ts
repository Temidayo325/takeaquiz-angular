import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class PrepService {

  constructor(
        private http: HttpClient,
        
 ) { }

     public baseUrl = "http://127.0.0.1:8000/api/v1/";
     protected questions: any = []
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

     store(questions: [])
     {
          this.questions = questions
     }

     retrieve()
     {
          return this.questions
     }
}
