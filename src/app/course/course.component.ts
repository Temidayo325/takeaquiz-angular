import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { CourseService } from '../Services/course.service';
import { StoreService } from '../Services/store.service';
import { ToastService } from 'angular-toastify';


@Component({
  selector: 'app-course',
  templateUrl: './course.component.html',
  styleUrls: ['./course.component.scss']
})
export class CourseComponent implements OnInit {

     courseForm = this.fb.group({
         course: ['', [Validators.required, Validators.minLength(3)]]
     });
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
  constructor(
       private fb : FormBuilder,
       private course: CourseService,
       private store: StoreService,
       private toast: ToastService
 ) { }
     public user: object = this.store.getUser();

  ngOnInit(): void {
       this.getCourse()
  }
  ngOnDestroy(): void {
       //Called once, before the instance is destroyed.
       //Add 'implements OnDestroy' to the class.
       this.sub.unsubscribe()
  }
  createForm()
  {
       this.sub = this.course.create({course: this.courseForm.value.course}).subscribe(
            (res) => {
                 this.toast.success(res.message)
                 this.getCourse()
                 this.showCourse = false
            },
            (err) => {
                 console.log(err)
                 this.errors = err.error.errors
                 this.toast.warn(err.error.message)
            }
       )
  }
  getCourse()
  {
       this.sub = this.course.get().subscribe(
            (res) => {
                 if (res.statusCode == 200) {
                      console.log(res.course)
                      this.courses = res.course
                      this.sortCourses(this.courses)
                 }
            },
            (err) => {
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
       let confirmed = confirm(`Are you sure you want to  Delete ${course.course} ?`)
       if ( confirmed ) {
            this.sub = this.course.deleteCourse({display_token: course.display_token}).subscribe(
                 (res) => {
                      this.toast.info(res.message)
                      this.courses.splice(this.courses.indexOf(course), 1)
                      this.sortCourses(this.courses)
                 },
                 (err) => {
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
       let user = {display_token: this.editCourseForm.value.display_token, start_time: this.editCourseForm.value.start_time, end_time: this.editCourseForm.value.end_time, duration: this.editCourseForm.value.duration, amount: this.editCourseForm.value.amount}
       this.sub = this.course.editCourse(user).subscribe(
            (res) => {
                 console.log(res)
                 this.toast.info(res.message)
                 this.getCourse()
                 this.edit = !this.edit
            },
            (err) => {
                 console.log(err)
                 this.errors = err.error.errors
                 this.toast.info(err.error.message)
            }
       )
  }
  downloadResult(course: any)
  {
       const now = new Date
       if (now > new Date(course.end_time) && course.end_time !== null) {
            this.sub = this.course.download("display_token="+course.display_token).subscribe(
                 (res) => {
                      this.toast.info("Download request initiated")
                 },
                 (err) => {
                      console.log()
                     this.toast.warn("Not working")
                 }
            )
       }else{
            this.toast.info("The course test is still on")
       }
  }
}
