import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { CourseService } from '../Services/course.service';
import { StoreService } from '../Services/store.service';
import { ToastService } from 'angular-toastify';
import { Title } from '@angular/platform-browser';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { slideInRightAnimation, slideOutRightAnimation } from 'angular-animations';

@Component({
  selector: 'app-course',
  templateUrl: './course.component.html',
  styleUrls: ['./course.component.scss'],
  animations: [
    // animation triggers go here
    slideInRightAnimation({duration: 2000}),
    slideOutRightAnimation()
  ]
})
export class CourseComponent implements OnInit {


     editCourseForm = this.fb.group({
         course: ['', [Validators.required]],
         display_token: ['', [Validators.required, Validators.minLength(6)]],
         duration: ['', [Validators.required, Validators.minLength(2)]],
         amount: ['', [Validators.required, Validators.minLength(2)]],
         start_time: ['', [Validators.required, Validators.minLength(9)]],
         end_time: ['', [Validators.required, Validators.minLength(2)]],
     });
     public errors: any = []
     public courses: any = []
     public overview: any = [
          {number: 0, text: 'Available courses'},
          {number: 0, text: 'Ongoing courses'},
          {number: 0, text: 'Completed courses'}
     ]
     public sub: any
     public showCourse: boolean = false
     public edit: boolean = false
     public modal: any = {display: false, assesments: [], display_token: '', index: 0}
  constructor(
       private fb : FormBuilder,
       private course: CourseService,
       private store: StoreService,
       private toast: ToastService,
       private title : Title,
       private loading: LoadingBarService,
 ) { }
     public user: object = this.store.getUser();

  ngOnInit(): void
  {
       this.loading.start()
       this.title.setTitle("Course board")
       this.getCourse()
       this.loading.complete()
  }
  ngOnDestroy(): void
  {
       this.sub.unsubscribe()
  }
  courseAdded():void
  {
       this.getCourse()
       this.showCourse = false
  }
  getCourse()
  {
       this.loading.start()
       this.sub = this.course.get().subscribe(
            (res) => {
                 if (res.statusCode == 200) {
                      this.courses = res.course
                      this.loading.complete()
                      this.sortCourses(this.courses)
                 }
            },
            (err) => {
                 this.loading.complete()
                 this.toast.warn(err.error.message)
            }
       )
  }
  sortCourses(arrays: any)
  {
       if (arrays.length !== 0) {
            this.overview[0].number = arrays.length
            this.overview[1].number = this.ongoingCourses(arrays)
            this.overview[2].number = this.completedCourses(arrays)
       }
  }

  ongoingCourses(arrays: []):number
  {
       const now = new Date()
       let newArray = arrays.filter(function(element: any, index: any){
            return now > new Date(element.start_time) && now < new Date(element.end_time)
       })
       return newArray.length
  }
  completedCourses(arrays: []):number
  {
       const now = new Date()
       let newArray = arrays.filter(function(element: any, index: any){
            return  now > new Date(element.end_time) && element.end_time !== null
       })
       return newArray.length
  }
  deleteCourse(course: any):void
  {
       this.loading.start()
       let confirmed = confirm(`Are you sure you want to  Delete ${course.course} ?`)
       if ( confirmed ) {
            this.sub = this.course.deleteCourse({display_token: course.display_token}).subscribe(
                 (res) => {
                      this.loading.complete()
                      this.toast.info(res.message)
                      this.courses.splice(this.courses.indexOf(course), 1)
                      this.sortCourses(this.courses)
                 },
                 (err) => {
                      this.loading.complete()
                      this.toast.warn(err.error.message)
                 }
            )
       }
  }
  editCourse(course: any): void
  {
       this.editCourseForm.patchValue({
            course: course.course,
            display_token: course.display_token,
            duration: course.duration,
            amount: course.amount,
            start_time: course.start_time,
            end_time: course.end_time
       })
       this.edit  = true
  }
  submitEditCourse(): void
  {
       this.loading.start()
       let user = {display_token: this.editCourseForm.value.display_token, start_time: this.editCourseForm.value.start_time, end_time: this.editCourseForm.value.end_time, duration: this.editCourseForm.value.duration, amount: this.editCourseForm.value.amount}
       this.sub = this.course.editCourse(user).subscribe(
            (res) => {
                 this.loading.complete()
                 this.toast.info(res.message)
                 this.getCourse()
                 this.edit = !this.edit
            },
            (err) => {
                 this.loading.complete()
                 this.errors = err.error.errors
                 this.toast.info(err.error.message)
            }
       )
  }
  downloadResult(course: any)
  {
       this.loading.start()
       const now = new Date
       if (now > new Date(course.end_time) && course.end_time !== null) {
            this.sub = this.course.download("display_token="+course.display_token).subscribe(
                 (res) => {
                      this.loading.complete()
                      this.toast.info("Download request initiated")
                 },
                 (err) => {
                     this.loading.complete()
                     this.toast.warn("Not working")
                 }
            )
       }else{
            this.loading.complete()
            this.toast.info("The course test is still on")
       }
  }
  public trackByFn(index: any, item: any):number
  {
    return index;
  }
  public checkCa(course: any, i: number)
  {
       this.modal.assesments = course.assesments
       this.modal.display_token = course.display_token
       this.modal.index = i
       this.modal.display = true
  }
  public toggleStatus(numb: number, status: string, index:number)
  {
       this.loading.start()
       this.course.toggleCaStatus({display_token: this.modal.display_token, index: numb}).subscribe(
            (res) => {
                 this.loading.complete()
                 this.toast.success(res.message)
                 this.modal.assesments[index].status = status
            },
            (err) => {
                 this.loading.complete()
                 this.toast.info(err.error.message)
            }
       )
  }
  public CreateCA()
  {
       this.loading.start()
       this.course.createCa({display_token: this.modal.display_token}).subscribe(
            (res) => {
                  this.toast.success(res.message)
                  this.courses[this.modal.index].assesments.push({numb: this.courses[this.modal.index].assesments.length + 1, status: 'inactive'})
                 this.loading.complete()
            },
            (err) => {
                 this.loading.complete()
                  this.toast.info(err.error.message)
            }
       )
  }
}
