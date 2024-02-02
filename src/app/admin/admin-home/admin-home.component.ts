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
import {Title} from '@angular/platform-browser';

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
       private title: Title
 ) { }

     private subscriptions!: Subscription
     public topics: Array<any> = this.storeService.topics
     public myTopics: Array<any> = []
     public totalQuestions: number = 0
     public totalUsers: number = 0
     public totalDepartments: number = 0
     public totalAssesments: number = 0
     public newTopic!: Subscription
     public navigation: boolean = false
     public user = JSON.parse(sessionStorage.getItem('user')!)
     public roles = this.storeService.getUserRoles()
     public monthlyStat: Array<any> = []
     public allTimeStat: Array<any> = []
     public editorStats = {total_topic_count: 0, monthly_topic_count: 0, total_questions_count: 0, monthly_questions_count: 0 }
     public topicsNavigation = {next: null, prev: null}
     public myTopicsNavigation = {next: null, prev: null}
     public current_month: string = ''
     public loadingInfoSkeleton: boolean = true
     public  responsiveOptions: Array<any> = []

     ngOnInit(): void
     {
          if(this.roles.admin)
          {
               this.loader.start()
               this.topicService.getMonthlyStatistics().subscribe(
                    (response: any) => {
                         if(response.status)
                         {
                              this.monthlyStat = response.monthly_data
                              this.allTimeStat = response.all_time_data
                              // this.topics = response.available_topics
                              this.current_month = response.current_month
                              this.loader.complete()
                              // console.log(response)
                         }
                    },
                    (error) => {
                         console.log(error)
                         this.loader.complete()
                    }
               )
          }

          if (this.roles.editor || this.roles.author) {
               this.loader.start()
               this.newTopic = this.topicService.get().subscribe(
                    ( response ) => {
                         if(response.status)
                         {
                              // if(!this.roles.admin)
                              // {
                                   this.topics = response.data.available_topics.data
                              // }
                              this.editorStats = response.editor
                              this.current_month = response.current_month
                              this.topicsNavigation.prev = response.data.available_topics.prev_page_url
                              this.topicsNavigation.next = response.data.available_topics.next_page_url
                              this.myTopics = response.data.my_topics.data
                              this.myTopicsNavigation.prev = response.data.my_topics.prev_page_url
                              this.myTopicsNavigation.next = response.data.my_topics.next_page_url
                              let all_topics = new Set([...response.data.available_topics.data, ...response.data.my_topics.data])
                              let topics_to_set = [...all_topics]
                              this.storeService.setTopics(topics_to_set)
                              this.loadingInfoSkeleton = false
                         }
                         this.loader.complete()
                    },

                    (error) => {
                         this.toast.error(error.error.message)
                         this.loader.complete()
                         console.log(error)
                    }
               )

               this.newTopic = this.shared.getAddedTopic().subscribe(
                    (resp) => {
                         this.topics.push(resp)
                         console.log(this.topics)
                         this.storeService.setTopics(this.topics)
                         this.router.navigate(['/admin/dashboard/home'])
                    }
               )
          }

     }

     trackByFn(index: number, topic: any)
       {
           return topic ? topic.id : undefined;
       }

     editTopic(topic_id: number)
       {

       }

      deleteTopic(id: number, index: number)
      {
           this.loader.start()
           if(confirm("Are you sure you want to delete topic ? "))
           {
                this.newTopic = this.topicService.delete(id).subscribe(
                     (response) => {
                          this.loader.complete()
                          this.toast.info("Topic removed succesfully")
                          this.topics.splice(index, 1);
                },

                     (error) => {
                          this.loader.complete()
                          this.toast.error(error.error.message)
                     }
                )
           }

      }

      paginateTopics(url: string)
     {
          this.loader.start()
          this.subscriptions = this.topicService.paginate(url).subscribe(
               (response: any) => {
                    this.topics = response.data.data
                    this.topicsNavigation.prev = response.data.available_topics.prev_page_url
                    this.topicsNavigation.next = response.data.available_topics.next_page_url
                    this.loader.complete()
               },
               (error : any) => {
                   this.loader.complete()
                   this.toast.error("Unable to load your topics")
               }
          )
     }
}
