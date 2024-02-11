import { Component, OnInit, OnDestroy } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { AssesmentService } from './../../service/assesment.service';
import { Router,  ActivatedRoute, ParamMap } from '@angular/router';
import { ToastService } from 'angular-toastify';
import {Title} from '@angular/platform-browser';
import { ShareService } from './../../services/share.service';


@Component({
  selector: 'app-prep',
  templateUrl: './prep.component.html',
  styleUrls: ['./prep.component.css']
})
export class PrepComponent implements OnInit, OnDestroy {

     form = new FormGroup({
            "faculty": new FormControl("", [Validators.required, Validators.minLength(4)]),
            "department": new FormControl("", [Validators.required, Validators.minLength(4)]),
            "topic_id": new FormControl("", [Validators.required, Validators.minLength(1)]),
     });

     constructor(
       private assesementService: AssesmentService,
         private loader: LoadingBarService,
         private router: Router,
         private toast: ToastService,
         private title: Title,
         private sharedService: ShareService
      ) {
           this.title.setTitle("Take assessment")
           this.sharedService.newHeader.next("Assessment")
      }
      get faculty() { return this.form.get('faculty'); }
      get department() { return this.form.get('department'); }
      get topic_id() { return this.form.get('topic_id'); }

      error: any = []
      topics: Array<any> = []
      departments: Array<string> = []
      titles: Array<any> = []
      totalAvailableQuestions: number = 0
      examDetails = {"duration": 0, "quantity": 0}
      examDetailsLoader: Boolean = false
      topicId: number =  1
      enableButton: boolean = false
      public user = JSON.parse(sessionStorage.getItem('user')!)

      ngOnInit(): void
      {
           this.loader.start()
           const topics = sessionStorage.getItem('topics')
           this.topics = topics === null ? [] : JSON.parse(topics)
           this.departments = this.distinctValues(this.topics)
           if(this.user.is_proffessional == 1)
           {
                this.chosenTopic({"target": {"value": 1}})
                this.topicId = 1
           }
           this.loader.complete()
      }

      onSubmit()
      {
           this.loader.start()
           const topic_id: any = ( this.form.value.topic_id != '' ) ? this.form.value.topic_id : this.topicId
           this.assesementService.requestAssesment(topic_id).subscribe(
                (response) => {
                     this.loader.complete()
                     if( !response.status && response.statusCode == 426)
                     {
                          this.toast.info(response.message)
                     }else{
                          if (response.status && response.data.questions != null) {
                              this.toast.info("You'll be redirected to your assessment")
                              sessionStorage.setItem('questions', JSON.stringify(response.data.questions))
                              sessionStorage.setItem('duration', response.data.duration)
                              // this.sharedService.topic_id.next(topic_id)
                              sessionStorage.setItem("assessment_topic_id", topic_id)
                              setTimeout(() => {
                                   this.router.navigate(['/user/dashboard/assessment'])
                              }, 5000)
                         }else{
                               this.toast.error("No questions are approves yet for this topic, kindly check out other topics while that is being done or contact the admin via the contact page")
                         }
                     }
                },

                (error) => {
                     this.loader.complete()
                     this.toast.error(error.message)
                     this.error = error.errors
                }
           )
      }

      distinctValues(values: Array<any>): Array<string>
      {
           let newArray: Array<string> = []
           values.forEach( (item, index) => {
                if (newArray.indexOf(item.department) === -1) {
                     newArray.push(item.department)
                }
           })
           return newArray
      }

      trackByFn(index: number, topic: any)
      {
          return topic ? topic.id : undefined;
      }

      chosenDepartment($event:any)
      {
           // console.log($event.target.value)
           this.titles = []
           this.topics.forEach((item, index) => {
                if (item.department.toLowerCase() === $event.target.value.toLowerCase() ) {
                     this.titles.push(item)
                }
           })
      }

      chosenTopic($event: any)
      {
           this.loader.start()
           this.enableButton = false
           this.assesementService.countTotalQuestion($event.target.value).subscribe(
                (response: any) => {
                     this.loader.complete()
                     this.totalAvailableQuestions = response.data.totalQuestions
                     this.examDetails = response.data.details
                     this.enableButton =  true
                     this.examDetailsLoader = true
                },

                (error: any) => {
                     this.loader.complete()
                     this.toast.error("Unable to retrieve the total number of questions for the chosen topic")
                     setTimeout(() => {
                          this.enableButton = true
                     }, 2000)
                }
           )

      }

      ngOnDestroy(): void
      {
           //Called once, before the instance is destroyed.
           //Add 'implements OnDestroy' to the class.

      }
}
