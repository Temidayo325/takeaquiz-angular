import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { ToastService } from 'angular-toastify';
import { TopicService } from './../../services/topic.service';
import { StoreService } from './../../service/store.service';
import { Router } from '@angular/router';
import { Subscription } from 'rxjs';
import { ShareService } from './../../services/share.service'

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent implements OnInit {

  constructor(
       private topicService: TopicService,
       private storeService: StoreService,
       private shared: ShareService,
       private loader: LoadingBarService,
       private toast: ToastService,
       private router: Router,
 ) { }

     public topics: Array<any> = this.storeService.topics
     public newTopic!: Subscription
  ngOnInit(): void
  {
       this.newTopic = this.topicService.get().subscribe(
            ( response ) => {
                 console.log(response)
                 this.topics = response.data
            },

            (error) => {
                 console.log(error)
            }
       )

       this.newTopic = this.shared.getAddedTopic().subscribe(
            (resp) => {
                 this.topics.push(resp)
                 this.router.navigate(['/admin/dashboard'])
            }
       )
  }

  trackByFn(index: number, topic: any) {
        return topic ? topic.id : undefined;
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
  ngOnDestroy(): void {
       //Called once, before the instance is destroyed.
       //Add 'implements OnDestroy' to the class.
       this.newTopic.unsubscribe();
  }
}
