import { Injectable } from '@angular/core';
import { Subject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ShareService {

  constructor() { }

  newTopicAdded = new Subject()

  getAddedTopic()
  {
       return this.newTopicAdded.asObservable()
 }
}
