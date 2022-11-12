import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { ToastService } from 'angular-toastify';
import { TopicService } from './../../services/topic.service';
import { UserService } from './../../service/user.service';
import { StoreService } from './../../service/store.service';
import { Router } from '@angular/router';
import { Subscription } from 'rxjs';
import { ShareService } from './../../services/share.service'

@Component({
  selector: 'app-admin-home',
  templateUrl: './admin-home.component.html',
  styleUrls: ['./admin-home.component.css']
})
export class AdminHomeComponent implements OnInit {

  constructor(
       private topicService: TopicService,
       private storeService: StoreService,
       private shared: ShareService,
       private loader: LoadingBarService,
       private toast: ToastService,
       private router: Router,
       private userService: UserService,
 ) { }
     public topics: Array<any> = this.storeService.topics
     public totalQuestions: number = 0
     public totalUsers: number = 0
     public totalDepartments: number = 0
     public totalAssesments: number = 0
     public newTopic!: Subscription
     public navigation: boolean = false
     public user = JSON.parse(sessionStorage.getItem('user')!)
     public imageSource: string = `https://avatars.dicebear.com/api/identicon/${this.user.nickname}.svg?mood[]=happy`


     ngOnInit(): void
     {
          this.newTopic = this.topicService.get().subscribe(
               ( response ) => {
                    this.topics = response.data
                    this.totalUsers = response.users
                    this.totalDepartments = response.faculties
                    this.totalAssesments = response.results
                    let questionTotalsArray: Array<number> = []
                    this.topics.forEach((current, index) => {
                         questionTotalsArray.push(current.question)
                    })
                    this.totalQuestions = questionTotalsArray.reduce((total, current, index) => {
                        return total + current
                   }, 0)
                    this.storeService.setTopics(this.topics)
               },

               (error) => {
                    console.log(error)
               }
          )

          this.newTopic = this.shared.getAddedTopic().subscribe(
               (resp) => {
                    this.topics.push(resp)
                    console.log(this.topics)
                    this.storeService.setTopics(this.topics)
                    this.router.navigate(['/admin/dashboard'])
               }
          )

     }
     trackByFn(index: number, topic: any) {
           return topic ? topic.id : undefined;
       }

       editTopic(topic_id: number)
       {

       }

      deleteTopic(id: number, index: number)
      {
           this.loader.start()
           this.newTopic = this.topicService.delete(id).subscribe(
                () => {
                     this.loader.complete()
                     this.topics.splice(index, 1);
                },

                (error) => {
                     this.loader.complete()
                }
           )
      }

}
