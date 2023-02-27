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
import { trigger, state, style, animate, transition } from '@angular/animations';
import {Title} from '@angular/platform-browser';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css'],
  animations: [
       trigger("openClose", [
              state('open', style({
                   transform: 'translateX(0)',
              })),
              state('close', style({
                   transform: 'translateX(-100%)',
              })),
              transition("open <=> close", animate("300ms linear"))
       ])
]
})
export class DashboardComponent implements OnInit {

  constructor(
       private topicService: TopicService,
       private storeService: StoreService,
       private shared: ShareService,
       private loader: LoadingBarService,
       private toast: ToastService,
       private router: Router,
       private title: Title,
       private userService: UserService,
 ) {
          this.title.setTitle("Admin dashboard")
   }

     public topics: Array<any> = this.storeService.topics
     public totalQuestions: number = 0
     public totalUsers: number = 0
     public totalDepartments: number = 0
     public newTopic!: Subscription
     public navigation: boolean = false
     public user = JSON.parse(sessionStorage.getItem('user')!)

  ngOnInit(): void
  {
       this.newTopic = this.topicService.get().subscribe(
            ( response ) => {
                 console.log(response)
                 this.topics = response.data
                 this.totalUsers = response.users
                 this.totalDepartments = response.faculties
                 let questionTotalsArray: Array<number> = []
                 this.topics.forEach((current, index) => {
                      questionTotalsArray.push(current.question)
                 })
                 this.totalQuestions = questionTotalsArray.reduce((total, current, index) => {
                     return total + current
                }, 0)
                 this.storeService.setTopics(this.topics)
                 this.router.navigate(['/admin/dashboard/home'])
            },

            (error) => {
                 console.log(error)
            }
       )

       this.newTopic = this.shared.getAddedTopic().subscribe(
            (resp) => {
                 this.topics.push(resp)
                 this.storeService.setTopics(this.topics)
                 this.router.navigate(['/admin/dashboard'])
            }
       )

  }

  toggleNavigation(): void
  {
       this.navigation = !this.navigation
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
                  this.toast.info("Topic removed successfully")
                  this.topics.splice(index, 1);
             },

             (error) => {
                  this.loader.complete()
                  this.toast.error(error.error.message)
             }
        )
   }

   logout(): void
   {
        if (confirm("Do you want to log out of your account?")) {
             this.loader.start()
             let user = JSON.parse(sessionStorage.getItem('user')!)
             this.userService.logout(user.id).subscribe(
                  (response: any) => {
                       this.loader.complete()
                       this.toast.info(response.message)
                       if (response.status) {
                            sessionStorage.clear()
                            localStorage.clear()
                            this.router.navigate(['/admin'])
                       }
                  },
                  (error) => {
                       this.loader.complete()
                       this.toast.error(error.error.message)
                  }
             )
        }
   }

   location(link: string)
   {
        this.router.navigate([link])
        this.toggleNavigation()

   }
  ngOnDestroy(): void {
       //Called once, before the instance is destroyed.
       //Add 'implements OnDestroy' to the class.
       this.newTopic.unsubscribe();
  }
}
