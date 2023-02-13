import { Component, OnInit } from '@angular/core';
import { TopicService } from './../services/topic.service';
import { Subscription } from 'rxjs';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {

  constructor(
       private topicService: TopicService,
 ) { }

  public statistics: any = {topics: 0, users: 0, assessments: 0}
  public sub!: Subscription
  ngOnInit(): void
  {
       this.sub  = this.topicService.publicGet().subscribe(
            (response) => {
                 // console.log(response)
                 this.statistics.users = response.users
                 this.statistics.assessments = response.results
                 let questionTotalsArray: Array<number> = []
                 response.data.forEach((current: any, index: number) => {
                      questionTotalsArray.push(current.question)
                 })
                 this.statistics.topics = questionTotalsArray.reduce((total, current, index) => {
                    return total + current
               }, 0)
          },
          (error) => {
               console.log(error)
          }
       )
  }

  ngOnDestroy(): void {
       //Called once, before the instance is destroyed.
       //Add 'implements OnDestroy' to the class.
       this.sub.unsubscribe()
  }
}
