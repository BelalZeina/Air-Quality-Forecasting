<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            "policy_en" => "(1) Provide complete information clearly and honestly (preferably photo)

                        (2) Communication through company representatives only.

                        (3) The value of the service (commission) is paid after full conviction of the crop. And communicate with one of the company's representatives, whose value is only 2%, after which the two parties are directly linked to each other.

                        (4) If not executed, full commission refund within one day with (deduction of 500 nominal administrative expenses).

                        (5) If the cause of non-performance is a defect in the information provided by the parties

                        Or violating the company's policy and market norms will be deleted.

                        From the platform directly for a year and if the reason is moral it will be permanently deleted

                        All information and details about the company, owner and management office are available at
                        The platform can be delivered at any time easily",
            "policy_ar" => "(1) تقديم المعلومات الكاملة بوضوح وأمانة (يفضل مع صورة).

                        (2) التواصل يكون من خلال ممثلي الشركة فقط.

                        (3) يتم دفع قيمة الخدمة (العمولة) بعد الاقتناع التام بالمحصول والتواصل مع أحد ممثلي الشركة، وتبلغ قيمتها 2% فقط، وبعد ذلك يتم ربط الطرفين ببعضهما مباشرة.

                        (4) في حالة عدم التنفيذ، يتم استرداد العمولة كاملة خلال يوم واحد (مع خصم 500 جنيه مصاريف إدارية اسمية).

                        (5) إذا كان سبب عدم التنفيذ هو وجود خلل في المعلومات المقدمة من الأطراف أو انتهاك سياسة الشركة والمعايير السوقية، فسيتم حذفها من المنصة مباشرة لمدة عام، وإذا كان السبب أخلاقيًا فسيتم حذفها نهائيًا.

                        تتوفر جميع المعلومات والتفاصيل المتعلقة بالشركة والمالك ومكتب الإدارة على المنصة ويمكن تسليمها في أي وقت بسهولة.",
        ]);
    }
}
