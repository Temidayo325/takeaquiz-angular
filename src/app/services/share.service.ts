import { Injectable } from '@angular/core';
import { Subject, Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ShareService {

  constructor() { }

  newTopicAdded = new Subject()
  newHeader = new Subject()
  topic_id = new Subject()

  getAddedTopic():Observable<any>
  {
       return this.newTopicAdded.asObservable()
  }

  getNewHeader():Observable<any>
  {
       return this.newHeader.asObservable()
  }

  getTopicId():Observable<any>
  {
     return this.topic_id.asObservable()
  }
}
