import { Component, OnInit } from '@angular/core';
import { ContentService } from './../../services/content.service';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { ToastService } from 'angular-toastify';
import { Router } from '@angular/router';
import { Subscription } from 'rxjs';
import {Title} from '@angular/platform-browser';
import { trigger, state, style, animate, transition } from '@angular/animations';

@Component({
  selector: 'app-content',
  templateUrl: './content.component.html',
  styleUrls: ['./content.component.css'],
  animations: [
       trigger("openClose", [
              state('open', style({
                   transform: 'translateX(0)',
              })),
              state('close', style({
                   transform: 'translateX(100%)',
              })),
              transition("open <=> close", animate("300ms linear"))
       ]),
       trigger("showHide", [
            state('show', style({
                  transform: 'translateY(0)',
            })),
            state('hide', style({
                  transform: 'translateY(-230%)',
            })),
            transition("show <=> hide", animate("400ms linear"))
      ])
]
})
export class ContentComponent implements OnInit {

  constructor(
       private content: ContentService,
       private loader: LoadingBarService,
       private toast: ToastService,
       private router: Router,
       private title: Title
 ) { }
  subscriptions!: Subscription
  navigation: boolean =  false
  topics: Array<{topic_id: number, title: string, faculty: string, department: string, content: Array<object>}> = []
  contents: Array<any> = []
  currentTopicId: number = 0
  chosenTopic: string = ''
  classes = {show: '', hide: '', form: false}
  navButtons = {prev: null, next: null}

  ngOnInit(): void
  {
       this.getAvailableTopics()
  }
  getAvailableTopics()
  {
       this.loader.start()
       this.subscriptions = this.content.index().subscribe(
            (response) => {
                 this.topics = response.data.data
                 this.navButtons.prev = response.data.prev_page_url
                 this.navButtons.next = response.data.next_page_url
                 // console.log(response)
                 this.loader.complete()
            },
            (error) => {
                this.loader.complete()
                this.toast.error("Unable to load your topics")
            }
       )
  }
  trackByFn(index: number, topic: any)
  {
        return topic ? topic.id : undefined;
   }
   viewContent(contents$: null | Array<unknown>, topic_id: number, topic: string)
   {
        if (contents$ !== null) {
             this.contents = contents$
        }
        this.currentTopicId = topic_id
        this.chosenTopic = topic
        this.navigation = !this.navigation
   }

   toggleNavigation(): void
   {
        if (this.navigation) {
             this.getAvailableTopics()
        }
       this.navigation = !this.navigation
   }

   addOutline(isEmpty: number):void
   {
        if (isEmpty === 1) {
             // That means the topic has zero outline prior to click
             this.classes.hide = 'translate-x-full ease-linear duration-500'
             this.classes.show = 'translate-y-[70%] ease-linear duration-300 delay-300'
             this.classes.form = true
        }
        if (isEmpty === 0) {
             // that means the topic has outlines prior to click

        }
   }

   outlineAdded($event: string)
   {
        // let chosenTopic = this.topics.find((current) => {
        //      return current.topic_id === this.currentTopicId
        // })
        this.contents.push({content: $event})
   }

   paginateContent(url: string)
   {
        this.loader.start()
        this.subscriptions = this.content.paginate(url).subscribe(
             (response) => {
                  this.topics = response.data.data
                  this.navButtons.prev = response.data.prev_page_url
                  this.navButtons.next = response.data.next_page_url
                  console.log(response)
                  this.loader.complete()
             },
             (error) => {
                 this.loader.complete()
                 this.toast.error("Unable to load your topics")
             }
        )
   }

  ngOnDestroy(): void
  {
       //Called once, before the instance is destroyed.
       //Add 'implements OnDestroy' to the class.
       this.subscriptions.unsubscribe()
  }
}
