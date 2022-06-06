import { Component, OnInit } from '@angular/core';
import { EChartsOption } from 'echarts';
import {StudentService} from '../Services/student.service';
import { ToastService } from 'angular-toastify';
@Component({
  selector: 'app-student',
  templateUrl: './student.component.html',
  styleUrls: ['./student.component.scss']
})
export class StudentComponent implements OnInit {
  constructor(
       private student: StudentService,
       private toast: ToastService,
 ) { }
  public overview: any = [
       {number: 0, text: 'Total number of student'},
       {number: 0, text: 'Last registered course'}
  ]
  public sub: any;
  public form: any = {matric: '', course: '', result: [], text: ''}
  public data: any = {xaxis: [], yaxis: []}
  chartOption: EChartsOption = {}

  ngOnInit(): void {
       this.getstudentGraph()
  }
  getstudentGraph()
  {
       this.sub = this.student.countCourseStudent().subscribe(
            (res) => {
                 res.courses.map((elem: any) =>{
                      this.data.xaxis.push(elem.course)
                 })
                 this.data.yaxis = res.count
                 this.chartOption = {
                      xAxis: {
                         type: 'category',
                         boundaryGap: false,
                         data: this.data.xaxis
                      },
                      yAxis: { },
                      series: [{
                         data: this.data.yaxis,
                         type: 'scatter',
                         color: ['blue']
                         // areaStyle: {}
                      }]
                     }
            },
            (err) => {
            }
       )
  }
  search()
  {
       if (this.form.matric.length < 6) {
            this.toast.warn("Invalid matric number")
       }else{
            this.sub = this.student.searchStudent(this.form.course, this.form.matric).subscribe(
                 (res) => {
                      if (res.student != null ) {
                           this.form.text = ''
                           this.form.result = res.student
                      }else{
                           this.form.text = 'No student with that matric number under the selected course'
                      }
                 },
                 (err) => {
                      this.toast.warn(err.error.message)
                 }
            )
       }

  }
  deleteStudent(matric: string)
  {
       if (confirm("Do you really want to delete the record of the student?")) {
            this.student.deleteStudent( this.form.course, matric).subscribe(
                 (res) => {
                      if (res.data != undefined) {
                           this.toast.error(res.data.message)
                      }else{
                           this.toast.info(res.message)
                           this.form.text = ''
                           this.form.result = []
                      }

                 },
                 (err) => {
                      this.toast.warn(err.error.message)
                 }
            )
       }
  }
  ngOnDestroy(): void
  {
       this.sub.unsubscribe()
  }
}
