import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { LoggeninUserGuard } from './guard/loggenin-user.guard';

import { LoginComponent } from './login/login.component';
import { HomeComponent } from './home/home.component';
import { AdminLoginComponent } from './admin-login/admin-login.component';
import { DashboardComponent } from './admin/dashboard/dashboard.component';
import { TopicComponent } from './forms/topic/topic.component';
import { QuestionComponent } from './forms/question/question.component';
import { VerifyQuestionComponent } from './admin/verify-question/verify-question.component';
import { UserDashboardComponent } from './user/user-dashboard/user-dashboard.component';
import { ResultsComponent } from './user/results/results.component';
import { AssessmentComponent } from './user/assessment/assessment.component';
import { PrepComponent } from './user/prep/prep.component';
import { Error404Component } from './errors/error404/error404.component';
import { VerifyAccountComponent } from './user/verify-account/verify-account.component';
import { RegisterComponent } from './register/register.component';
import { AdminHomeComponent } from './admin/admin-home/admin-home.component';

const routes: Routes = [
     { path: 'index', component: HomeComponent },
     {path: 'login', component: LoginComponent},
     {path: 'register', component: RegisterComponent},
     {path: 'verify-account', component: VerifyAccountComponent},
     {path: 'admin', component: AdminLoginComponent},
     {path: 'user/dashboard', component: UserDashboardComponent,
          canActivateChild: [LoggeninUserGuard],
          canLoad: [LoggeninUserGuard],
          canActivate: [LoggeninUserGuard],
          children: [
               {
                    path: 'results',
                    component: ResultsComponent
               },
               {
                    path: 'take-assessment',
                    component: PrepComponent
               }
          ]},
     {path: 'user/assessment', component: AssessmentComponent},
     {path: 'admin/dashboard', component: DashboardComponent,
          children: [
               {
                    path: 'forms/topic',
                    component: TopicComponent
               },
               {
                    path: 'forms/question',
                    component: QuestionComponent
               },
               {
                    path: 'topic/:id',
                    component: VerifyQuestionComponent
               },
               {
                    path: 'home',
                    component: AdminHomeComponent
               }
          ]},
     { path: '', redirectTo: '/index', pathMatch: 'full' },
     { path: '**', component: Error404Component },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
