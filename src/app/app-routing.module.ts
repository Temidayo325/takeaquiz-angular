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

const routes: Routes = [
     {path: 'login', component: LoginComponent},
     {path: 'verify-password', component: VerifyPasswordComponent},
     {path: 'dashboard', component: DashboardComponent,
     children: [
          {path: 'home', component: HomeComponent},
          {path: 'course', component: CourseComponent},
          {path: 'question', component: QuestionComponent},
          {path: 'change-password', component: ChangePasswordComponent},
     ]},
     {path: 'forgot-password', component: ForgotPasswordComponent},
     {path: 'change-password', component: ChangePasswordComponent},
     { path: '', redirectTo: '/login', pathMatch: 'full' },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
