import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { CourseService } from '../Services/course.service';
import { AssessmentTakersResponse } from '../models/assessment-takers';
import { Drawer } from 'flowbite';
import type { DrawerOptions, DrawerInterface } from 'flowbite';
import type { InstanceOptions } from 'flowbite';

@Component({
  selector: 'app-assessment-takers',
  templateUrl: './assessment-takers.component.html',
  styleUrls: ['./assessment-takers.component.scss']
})
export class AssessmentTakersComponent implements OnInit {

  constructor(
       private route: ActivatedRoute,
       private courseService: CourseService,
 ) { }

  public students: AssessmentTakersResponse = { current_page: 0, data: [],  first_page_url: null, from: null, last_page: null, last_page_url:null,  links: [], next_page_url: null,  path: '',  per_page: 0,  prev_page_url: null,  to: 0, total: 0 }
  public scripts: Array<any> = []

  ngOnInit(): void
  {
       const assessmentDisplayToken: string = this.route.snapshot.paramMap.get('display_token')!;
       this.courseService.assessmentTakers(assessmentDisplayToken).subscribe(
            (response) => {
                 // console.log(response)
                 this.students = response.course
            },
            (error) => {
                 alert("wahala")
                 console.log(error)
            }
       )
  }

  showScripts(scripts: string)
  {
       console.log(JSON.parse(scripts))
       this.scripts = JSON.parse(scripts)
       const sideBar = this.openSideBar()
       sideBar.show();
  }

  public openSideBar():DrawerInterface
  {
       const $targetEl: HTMLElement = document.getElementById("drawer-right-example")!;
       const options: DrawerOptions = {
           placement: 'right',
           backdrop: true,
           bodyScrolling: false,
           edge: false,
           edgeOffset: ''
       };
       const instanceOptions: InstanceOptions = {
       id: 'drawer-right-example',
       override: true
       };
       const drawer: DrawerInterface = new Drawer($targetEl, options, instanceOptions);
       return drawer;
  }

  public closeSidebar()
  {
       const sideBar = this.openSideBar()
       sideBar.hide()
  }
  public trackByFn(index: any, item: any):number
  {
      return index;
  }

  nextPageAction(action: string)
  {
      let url = (action == 'next') ? this.students.next_page_url! : this.students.last_page_url!
      this.courseService.paginateAssessmentTakers(url).subscribe(
           (response) => {
                this.students = response.course
           },
           (error) => {
                console.log(error)
                alert("Wahala ti wa o!!!!!!!!")
           }
      )
  }
}
