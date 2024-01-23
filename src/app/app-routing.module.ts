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
import { UserHomeComponent } from './user/user-home/user-home.component';
import { LoaderComponent } from './components/loader/loader.component';
import { ConfirmComponent } from './components/confirm/confirm.component';
import { RecoverPasswordComponent } from './user/recover-password/recover-password.component';
import { ChangePasswordComponent } from './forms/change-password/change-password.component';
import { SharedResultComponent } from './user/shared-result/shared-result.component';
import { ContentComponent } from './admin/content/content.component';
import { UserComponent } from './admin/user/user.component';
import { ChooseAssessmentStatusComponent } from './choose-assessment-status/choose-assessment-status.component';

const routes: Routes = [
     { path: 'index', component: HomeComponent },
     {path: 'login', component: LoginComponent},
     {path:  'assessment-status', component: ChooseAssessmentStatusComponent},
     {path: 'register', component: RegisterComponent},
     {path: 'verify-account', component: VerifyAccountComponent},
     {path: 'recover-password', component: RecoverPasswordComponent},
     {path: 'change-password', component: ChangePasswordComponent},
     {path: 'admin', component: AdminLoginComponent},
     {path: 'spinner', component: LoaderComponent},
     {path: 'confirm', component: ConfirmComponent},
     {path: 'user/dashboard', component: UserDashboardComponent,
          canActivateChild: [LoggeninUserGuard],
          canLoad: [LoggeninUserGuard],
          canActivate: [LoggeninUserGuard],
          children: [
               {
                    path: 'home',
                    component: UserHomeComponent,
                    // data: { animation: 'insertRemovePage' }
               },
               {
                    path: 'results',
                    component: ResultsComponent,
                    // data: { animation: 'insertRemovePage' }
               },
               {
                    path: 'take-assessment',
                    component: PrepComponent,
                    // data: { animation: 'insertRemovePage' }
               },
               {
                    path: 'assessment',
                    component: AssessmentComponent
               }
          ]},
     // {path: 'user/assessment', component: AssessmentComponent},
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
                    path: 'user',
                    component: UserComponent
               },
               {
                    path: 'content',
                    component: ContentComponent
               },
               {
                    path: 'home',
                    component: AdminHomeComponent
               }
          ]},
     {path: 'share/result/:code', component: SharedResultComponent},
     { path: '', redirectTo: '/index', pathMatch: 'full' },
     { path: '**', component: Error404Component },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
