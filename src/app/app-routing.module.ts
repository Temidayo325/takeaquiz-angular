import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { LoginComponent } from './login/login.component';
import { VerifyPasswordComponent } from './verify-password/verify-password.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { ForgotPasswordComponent } from './forgot-password/forgot-password.component';
import { ChangePasswordComponent } from './change-password/change-password.component';
import { HomeComponent } from './home/home.component';
import { CourseComponent } from './course/course.component';
import { QuestionComponent } from './question/question.component';
import { StudentComponent } from './student/student.component';
import { PrepComponent } from './prep/prep.component';
import { QuizComponent } from './quiz/quiz.component';
import { ComplaintsComponent } from './complaints/complaints.component';
import { HomepageComponent } from './homepage/homepage.component';
import { InstructionsComponent } from './instructions/instructions.component';
import { AddCalculationComponent } from './add-calculation/add-calculation.component';
import { PageNotFoundComponent } from './page-not-found/page-not-found.component';
import { GermanComponent } from './german/german.component';
const routes: Routes = [
     {path: 'homepage', component: HomepageComponent},
     {path: 'login', component: LoginComponent},
     {path: 'verify-password', component: VerifyPasswordComponent},
     {path: 'dashboard', component: DashboardComponent,
          children: [
               {path: 'home', component: HomeComponent},
               {path: 'course', component: CourseComponent},
               {path: 'question', component: QuestionComponent},
               {path: 'change-password', component: ChangePasswordComponent},
               {path: 'student', component: StudentComponent},
               {path: 'complaint', component: ComplaintsComponent},
               {path: 'set-theory', component: AddCalculationComponent},
               {path: 'set-german', component: GermanComponent},
     ]},
     {path: 'forgot-password', component: ForgotPasswordComponent},
     {path: 'prep', component: PrepComponent},
     {path: 'quiz', component: QuizComponent},
     {path: 'instructions', component: InstructionsComponent},
     {path: 'change-password', component: ChangePasswordComponent},
     { path: '', redirectTo: '/homepage', pathMatch: 'full' },
     { path: '**', component: PageNotFoundComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
