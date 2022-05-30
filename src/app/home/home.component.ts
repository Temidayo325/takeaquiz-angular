import { Component, OnInit } from '@angular/core';
import { CourseService } from '../Services/course.service';
import { StoreService } from '../Services/store.service';
import { ToastService } from 'angular-toastify';
import { Router } from '@angular/router';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  constructor(
       private course: CourseService,
       private store: StoreService,
       private toast: ToastService,
       private router: Router
 ) { }
  public sub: any ;
  public courses: any = []
  public overview: any = [
       {number: 0, text: 'Available courses'},
       {number: 0, text: 'Ongoing courses'},
       {number: 0, text: 'Completed courses'}
  ]
  ngOnInit(): void {
       this.getCourse()
  }
  goToCourses()
  {
       this.router.navigate(['/dashboard', {route: 'courses'}])
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
}
