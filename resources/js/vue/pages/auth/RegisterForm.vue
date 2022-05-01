<template>
  <div>
    <div class="py-8 bg-slate-200">
      <h2 class="text-3xl text-center">無料会員登録</h2>
      <step :step="step"></step>
    </div>
    <div class="pt-10 pb-16">
      <div class="container">
        <transition-group name="fade" tag="div">
          <ValidationObserver v-show="step === 1" ref="form" v-slot="{ passes }" key="form-1" tag="div">
            <form novalidate @submit.prevent="passes(onSubmit)" @keyup.enter="passes(onSubmit)">
              <p v-if="apiError" class="text-gray-400 text-red-600 text-center mb-5">{{ apiError[0] }}</p>

              <v-input-full-name
                :value-first-name.sync="firstName"
                :value-last-name.sync="lastName"
                class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
                label="担当者名"
                placeholder-first-name="姓"
                placeholder-last-name="名"
                type="text"
                vid-first-name="first_name"
                vid-last-name="last_name"
                first-name="姓"
                last-name="名"
                rules-first-name="required|max:255"
                rules-last-name="required|max:255"
              ></v-input-full-name>
              <v-input
                v-model="phone"
                class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
                wrapper-class="col-span-12 lg:col-span-4"
                label="携帯電話番号"
                help="※ハイフンなしの電話番号を入力してください。"
                placeholder="例）09012341234"
                type="text"
                vid="phone"
                name="携帯電話番号"
                rules="required|phone"
              ></v-input>
              <v-input
                v-model="email"
                class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
                wrapper-class="col-span-12 lg:col-span-6"
                label="メールアドレス"
                help="※ログインIDになります。"
                placeholder="steerlink@steerlink.com"
                type="text"
                vid="email"
                name="メールアドレス"
                rules="required|email|max:255"
              ></v-input>
              <v-input
                v-model="password"
                class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
                wrapper-class="col-span-12 lg:col-span-4"
                label="パスワード"
                help="※半角英数字 8文字以上で入力してください。"
                type="password"
                vid="password"
                name="パスワード"
                rules="required|min:8|max:255"
              ></v-input>
              <v-input
                v-model="passwordConfirmation"
                class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
                wrapper-class="col-span-12 lg:col-span-4"
                label="パスワード確認"
                help="※半角英数字 8文字以上で入力してください。"
                type="password"
                vid="password_confirmation"
                name="パスワード確認"
                rules="required|confirmed:password"
              ></v-input>
              <v-input
                v-model="companyName"
                class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
                label="会社名"
                placeholder="株式会社ステアリンク"
                type="text"
                vid="company_name"
                name="会社名"
                rules="required|max:255"
              ></v-input>
              <v-select
                v-model="businessType"
                class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
                wrapper-class="col-span-12 lg:col-span-3"
                label="事業形態"
                placeholder="選択してください"
                option-class="text-black"
                default-option-class="text-gray-400"
                vid="business_type"
                name="事業形態"
                rules="required"
                default-text="選択してください"
                :options="optionsBusiness"
              ></v-select>
              <v-input
                v-model="zipcode"
                class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
                wrapper-class="col-span-12 lg:col-span-3"
                label="本社住所 郵便番号"
                help="※ハイフンなしの郵便番号を入力してください。"
                placeholder="例）2850803"
                type="text"
                vid="zipcode"
                name="本社住所 郵便番号"
                rules="required|numeric|min:7|max:7"
              ></v-input>
              <v-select
                v-model="prefecture"
                class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
                label="都道府県"
                placeholder="選択してください"
                option-class="text-black"
                default-option-class="text-gray-400"
                vid="prefecture"
                name="都道府県"
                rules="required"
                default-text="選択してください"
                :options="optionsPrefecture"
                wrapper-class="col-span-12 lg:col-span-3"
              ></v-select>
              <v-input
                v-model="city"
                class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
                label="市区町村"
                help=""
                placeholder=""
                type="text"
                vid="grid"
                name="市区町村"
                rules="required|max:255"
                wrapper-class="col-span-12 lg:col-span-6"
              ></v-input>
              <v-input
                v-model="address"
                class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
                label="番地・ビル名など"
                help=""
                placeholder="建物名など"
                type="text"
                vid="address"
                name="番地・ビル名など"
                rules="max:255"
                wrapper-class="col-span-12 lg:col-span-6"
              ></v-input>
              <div class="relative appearance-none w-full TextInput grid grid-cols-12 gap-4 mb-4 lg:mb-8">
                <label class="pt-3.5 col-span-12 lg:col-span-4 text-slate-700"></label>
                <div class="col-span-12 lg:col-span-4">
                  <button type="submit" class="btn btn-primary btn-lg btn-wide rounded btn-icon w-full">
                    入力確認 <i class="fa fa-arrow-right"></i>
                  </button>
                </div>
              </div>
            </form>
          </ValidationObserver>

          <!-- FORM CONFIRM -->
          <div v-if="step === 2" key="form-2">
            <p class="mb-4">各ご記入内容に間違いがないか、ご確認ください。</p>
            <div class="border border-zinc-400 w-full grid grid-cols-1 bg-white mb-8">
              <AttributeShow label="担当者名" :value="firstName + ' ' + lastName" />
              <AttributeShow label="携帯電話番号" :value="phone" />
              <AttributeShow label="メールアドレス" :value="email" />
              <AttributeShow label="パスワード" value="********" />
              <AttributeShow label="パスワード確認" value="********" />
              <AttributeShow label="会社名" :value="companyName" />
              <AttributeShow label="事業形態" :value="optionsBusiness[businessType] || ''" />
              <AttributeShow label="郵便番号" :value="zipcode" />
              <AttributeShow label="都道府県" :value="optionsPrefecture[prefecture] || ''" />
              <AttributeShow label="市区町村" :value="city" />
              <AttributeShow label="番地・ビル名など" :value="address" />
            </div>
            <p class="mb-3">以下の「アイナビトラック 無料利用規約」をよくお読みの上、同意していただくことが必要です。</p>
            <ValidationObserver ref="form2" v-slot="{ passes }" tag="div">
              <form novalidate @submit.prevent="passes(onSubmitConfirm)" @keyup.enter="passes(onSubmitConfirm)">
                <div>
                  <div class="bg-white p-8 border h-60 overflow-y-auto">
                    <h2 class="text-3xl text-center mb-8">利用規約</h2>
                    <div class="lg:px-8 lg:mx-8 sm:px-3 lg:mb-8">
                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第1条（目的）</p>
                        <p class="mb-2">アイナビ利用規約（以下、「本規約」といいます。）は、株式会社ステアリンク（以下、「当社」といいます。）がサービス利用者に提供する本サービス（第2条で定義します。）の利用条件を定めるものです。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第2条（定義）</p>
                        <p class="mb-2">本規約において使用する用語は、次の各号に定める意味を有するものとします。</p>
                        <p class="mb-2">（1）「本サービス」とは、当社が提供する「アイナビ」という名称のサービス（理由の如何を問わずサービスの名称または内容が変更された場合は、当該変更後のサービスを含みます。）を意味し、その内容は第5条（本サービスの概要）に定めます。</p>
                        <p class="mb-2">（2）「本ウェブサイト」とは、そのドメインが <a class="text-blue-500 hover:text-blue-800" href="https://ainavi.jp/">「https://ainavi.jp/」</a>である、当社の委託先が運営するウェブサイトを意味します。</p>
                        <p class="mb-2">（3）「サービス利用者」とは、本規約第6条に基づき、本サービスの利用登録を完了した個人および法人を意味します。</p>
                        <p class="mb-2">（4）「サービス利用契約」とは、当社とサービス利用者との間で本規約に基づいて締結される、本サービスの利用契約を意味します。</p>
                        <p class="mb-2">（5）「掲載者」とは、サービス利用者のうち、本サービスを利用して車両情報等を本ウェブサイトに掲載する個人または法人を意味します。</p>
                        <p class="mb-2">（6）「問い合わせ会員」とは、サービス利用者のうち、本サービスを利用して掲載車両等を購入する個人または法人（中古設備専門業者を含みます。）を意味します。</p>
                        <p class="mb-2">（7）「掲載車両等」とは、本ウェブサイト等を通じて掲載することが可能な、掲載者が所有する車両情報を意味します。</p>
                        <p class="mb-2">（8）「掲載車両等情報」とは、掲載者が本ウェブサイト等上に掲載する掲載車両等に関する情報を意味します。</p>
                        <p class="mb-2">（9）「掲載車両等売買契約」とは、問い合わせ会員と掲載者とにおける掲載車両等の売買契約を意味し、掲載車両等料金額、支払手段、支払日、輸送料等の負担者の定めはこれに含まれます。</p>
                        <p class="mb-2">（10）「知的財産権」とは、特許権、実用新案権、育成者権、意匠権、著作権、商標権その他の知的財産に関して法令により定められた権利または法律上保護される利益に係る権利を意味します。</p>
                        <p class="mb-2">（12）「個人情報」とは、生存する個人に関する情報であって、当該情報に含まれる氏名、生年月日その他の記述などによって特定の個人を識別できるもの（他の情報と容易に照合することができ、それによって特定の個人を識別することができることとなるものを含みます。）、または個人識別符号が含まれるものを意味します。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第3条（本規約の適用・同意）</p>
                        <p class="mb-2">1．本規約は、サービス利用者と当社との間の本サービスの利用に関わる一切の関係に適用されるものとします。</p>
                        <p class="mb-2">2．本規約のほか、当社が定め、本ウェブサイト上で掲載する本サービスの利用に関するご利用方法、各種規定（以下、本条において「各種規定等」といいます。）は、本規約の一部を構成するものとします。</p>
                        <p class="mb-2">3．本規約の内容と、前項の各種規定等との内容が異なる場合は、各種規定等が優先して適用されるものとします。なお、本サービスの利用に関し、本サービスをご利用になるお客様と当社との間で別途の合意を締結している場合であって、本規約の内容と当該合意の内容が異なる場合も同様とします。</p>
                        <p class="mb-2">4.登録希望者は、第6条に定める利用登録を完了した時点で、本規約の内容に同意したものとみなされます。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第4条（利用規約の変更）</p>
                        <p class="mb-2">1．当社は、当社の判断で自由に本規約を変更できるものとします。</p>
                        <p class="mb-2">2．当社は、前項に基づき、本規約を変更した場合には、本ウェブサイトに提示することによってサービス利用者に通知するものとし、当社が別途定める場合を除いて本ウェブサイトへ掲示された時点からその効力を生じるものとします。当該変更内容の通知後、サービス利用者が第17条（退会）に定める退会の手続きをとらなかった場合、または本サービスを引き続き利用した場合には、サービス利用者は、本規約の変更に同意したものとみなされます。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第5条（本サービスの概要）</p>
                        <p class="mb-2">1．本サービスは、掲載車両等を本ウェブサイトに公開する掲載者と、掲載車両等の問い合わせをする会員のマッチングプラットフォームを提供するサービスです。サービス利用者は、掲載車両等の情報を共有することができます。</p>
                        <p class="mb-2">2．当社が本サービスにおいてサービス利用者に提供する内容は、以下の各号となります。</p>
                        <p class="mb-2">（1）本サイトの管理および運営</p>
                        <p class="mb-2">（2）掲載車両等情報の掲載・削除およびそのサポート</p>
                        <p class="mb-2">（3）問い合わせ会員からの問い合わせ、掲載の内容変更・取消、苦情その他の掲載者と問い合わせ会員との間の連絡の取次ぎ</p>
                        <p class="mb-2">（4）その他、当社が本サービスにおいて提供を決定した内容</p>
                        <p class="mb-2">3．掲載車両等売買に関わるやり取りは、掲載者と問い合わせ会員との間で直接行われるものとします。</p>
                        <p class="mb-2">4．当社は、自ら前項に定める掲載車両等のやり取りを行うものではなく、および掲載車両等の売買の委託を受けるものではありません。当社は、サービス利用者間の取引に関して、理由を問わず一切の責任を負いません。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第6条（利用登録）</p>
                        <p class="mb-2">1．本サービスの利用を希望する個人または法人（以下、「登録希望者」といいます。）は、以下を含む当社が指定する情報（以下、「登録情報」といいます。）を入力して本サービスの利用登録を申請し、当社がこれを承認することによって完了するものとします。なお、登録の申請は、必ず本サービスを利用するユーザー自身が行わなければならず、原則として代理人による登録申請は認められません。
                          担当者名・携帯電話番号・メールアドレス・事業形態・住所
                        </p>
                        <p class="mb-2">2．登録希望者が未成年者である場合は、親権者など法定代理人の同意（本規約への同意を含みます）を得たうえで本サービスを利用するものとします。また、本規約に同意した時点で未成年者であった登録希望者が、成年に達した後に本サービスを利用した場合、未成年者であった間の利用行為を追認したものとみなします。</p>
                        <p class="mb-2">3．第１項に定める登録の完了時に、当社と登録希望者との間にサービス利用契約が成立し、登録希望者はサービス利用者となり、本サービスを本規約に従い利用することができるようになります。</p>
                        <p class="mb-2">4．当社は、登録申請を行った登録希望者が、以下の各号のいずれかの事由に該当する場合は、登録および再登録を拒否することがあります。なお、この場合、当社はその理由について一切開示義務を負わないものといたします。</p>
                        <p class="mb-2">（1）当社に提供した登録情報の全部または一部につき虚偽、誤記または記載漏れがあった場合</p>
                        <p class="mb-2">（2）登録希望者が未成年者、成年被後見人、被保佐人又は被補助人のいずれかであり、法親権者、後見人、保佐人又は補助人の同意等を得ていなかった場合</p>
                        <p class="mb-2">（3）登録希望者が、過去、当社との契約に違反した者または本規約に違反したことがある者およびその関係者であると当社が判断した場合</p>
                        <p class="mb-2">（4）登録希望者が、第16条第1項に定める反社会的勢力に該当すると当社が判断した場合</p>
                        <p class="mb-2">（5）第15条（利用制限および登録抹消）に定める措置を受けたことがある場合</p>
                        <p class="mb-2">（6）登録希望者による本サービスの利用が法令その他規制（日本の法令・規制に限りません。）に違反するおそれがあると当社が判断した場合、または過去に違反したことがある場合</p>
                        <p class="mb-2">（7）その他、当社が登録を行うことが適当ではないと判断した場合</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第7条（登録情報の変更）</p>
                        <p class="mb-2">1．サービス利用者は、登録情報について真実、正確かつ完全な情報を提供しなければならず、登録情報に変更があった場合、当社の定める方法により変更のあった事項を遅滞なく当社に通知するものとします。</p>
                        <p class="mb-2">2．サービス利用者が前項の通知を怠ったことにより不利益を被った場合、当社は一切その責任を負わないものとします。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第8条（パスワード等の管理）</p>
                        <p class="mb-2">1．サービス利用者は、本サービスの利用開始にあたり、本サービスにログインするためのパスワードを設定するものとします。</p>
                        <p class="mb-2">2．サービス利用者は、自己の責任において、そのパスワードおよび登録情報等の情報を管理および保管するものとし、これを第三者に利用させること、または通知、貸与、譲渡、名義変更、売買等をしてはならないものとします。当社は、メールアドレスとパスワードの組み合わせが一致してログインされた場合には、サービス利用者自身によるログインとみなします。</p>
                        <p class="mb-2">3．サービス利用者は、パスワードが第三者に漏洩した場合、またはパスワードが第三者に使用された疑い等のある場合には、直ちに当社にその旨連絡するとともに、当社の指示がある場合にはその指示に従うにものとします。この場合、当社はそのアカウントの使用を停止することができるものとします。</p>
                        <p class="mb-2">4．パスワードの管理不十分、およびパソコンや携帯電話機等の端末の管理不十分、使用上の過誤、第三者の使用等による損害の責任はサービス利用者が負うものとし、当社は、理由を問わず一切の責任を負いません。これらの事由により当社に損害が生じた場合、サービス利用者はその損害を賠償する責任を負うものとします。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第9条（本サービスの利用）</p>
                        <p class="mb-2">1．サービス利用者は、第21条（有効期間）に定めるサービス利用契約の有効期間中、本規約の目的の範囲内かつ本規約に違反しない範囲内で、当社の定める方法に従い、本サービスを利用することができます。</p>
                        <p class="mb-2">2．本サービスの提供を受けるために必要な機器、通信回線その他の通信環境等の準備および維持は、サービス利用者の費用と責任において行うものとします。当社は、これらに対して、理由を問わず一切の責任を負いません。</p>
                        <p class="mb-2">3．サービス利用者は自己の本サービスの利用環境に応じて、コンピューター・ウィルスの感染の防止、不正アクセスおよび情報漏洩の防止等のセキュリティ対策を自らの費用と責任において講じるものとします。当社は、これらに対して、理由を問わず一切の責任を負いません。</p>
                        <p class="mb-2">4．サービス利用者が本サービスの利用にあたり、第三者の名誉を毀損した場合、プライバシー権を侵害した場合、著作権法に違反する行為を行った場合、その他他人の権利を侵害した場合、サービス利用者は自身の責任と費用においてこれを解決しなければならず、当社は、理由を問わず一切の責任を負いません。</p>
                        <p class="mb-2">5．当社は、サービス利用者が本サービスの利用により送受信したメッセージ、その他の情報を運営上一定期間保存していた場合といえども、これらの情報を保存する義務を負うものではありません。当社は、サービス利用者が、これらの情報を自ら保存しないことを起因としてサービス利用者に生じた損害について、理由を問わず一切の責任を負いません。</p>
                        <p class="mb-2">6．当社は、当社の判断で、自由に本サービスに当社または第三者の広告を掲載することができるものとします。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第10条（車両情報の掲載）</p>
                        <p class="mb-2">1．掲載手続等</p>
                        <p class="mb-2">掲載者は、本ウェブサイト上に掲載された当社所定の手続に従い商品の掲載を行うものとします。 当社は、掲載者および掲載方法について、基準を設け、審査を行い、掲載者が基準に合致しない場合には、当該掲載方法の利用を制限することができます。</p>
                        <p class="mb-2">2．掲載の手続き</p>
                        <p class="mb-2">掲載者は、本サービスの利用にあたり、以下の各号の行為を行うものとします。これらの各号のいずれかを行わなかった場合に、本サービスの利用に支障が生じたとしても、当社は一切の責任を負いません。</p>
                        <p class="mb-2">（1）掲載車両等情報の本サービスへの掲載手続き</p>
                        <p class="mb-2">（2）問い合わせ会員からの問い合わせ、苦情、その他の連絡に対する対応</p>
                        <p class="mb-2">（3）問い合わせ会員との掲載車両等売買契約の締結およびその適切かつ誠実な履行</p>
                        <p class="mb-2">3．掲載可能な車両情報</p>
                        <p class="mb-2">掲載者は、次項に定める商品（以下「掲載可能商品」といいます。）を掲載するものとし、掲載可能商品以外の商品の掲載を行わないものとします。掲載可能商品以外の商品を掲載した場合は、掲載者の故意または過失の有無に関わらず、本規約等の違反行為とみなします。</p>
                        <p class="mb-2">4．掲載可能商品</p>
                        <p class="mb-2">(1) 掲載車両が、掲載者の所有権に属すること。</p>
                        <p class="mb-2">(2) 掲載車両が、盗難品又は遺失物その他犯罪等によって入手した物ではなく、第三者に対する担保権その他の設定がなく、またその他の制約が一切付されていない他、第三者から何らかの権利主張がなされる可能性がないこと。</p>
                        <p class="mb-2">5．掲載者は、前項以外の商品の掲載を希望する場合または前項のどちらに該当するかわからない場合には、お問い合わせページより当社に確認の上、掲載するものとします。</p>
                        <p class="mb-2">6．掲載者は、本サービス以外の類似サービスにおいて掲載を行わないものとします。</p>

                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第1条（目的）</p>
                        <p class="mb-2">アイナビ利用規約（以下、「本規約」といいます。）は、株式会社ステアリンク（以下、「当社」といいます。）がサービス利用者に提供する本サービス（第2条で定義します。）の利用条件を定めるものです。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第11条（禁止事項）</p>
                        <p class="mb-2">1．当社は、以下のいずれかの事由に該当すると判断した場合には、サービス利用者に事前に通知することなく本サービスの全部または一部（仕様、ルール、デザイン、視聴覚的表現、その他一切の事項を含みます。）の提供を停止することができるものとします。</p>
                        <p class="mb-2">（1）本サービスにかかるコンピュータシステムの点検または保守作業を定期的または緊急に行う場合</p>
                        <p class="mb-2">（2）本サービスにかかるコンピュータシステムの障害、本サービスの連携サービス等のトラブル・サービス提供停止・廃止、その他本サービスの提供に必要な設備の障害等により本サービスの提供が困難となった場合</p>
                        <p class="mb-2">（3）コンピュータまたは通信回線等が事故により停止した場合</p>
                        <p class="mb-2">（4）地震、落雷、火災、停電または天災などの不可抗力により、本サービスの提供が困難となった場合</p>
                        <p class="mb-2">（5）法令等に基づく措置により本サービスの提供ができないとき</p>
                        <p class="mb-2">（6）その他、当社が本サービスの提供が困難と判断した場合</p>
                        <p class="mb-2">（7）第三者に本サービスを利用させる行為</p>
                        <p class="mb-2">（8）当社のサービスに関連して、反社会的勢力等に対して直接または間接に利益を供与する行為</p>
                        <p class="mb-2">（9）当社、他のサービス利用者または第三者の知的財産権、肖像権、プライバシー、名誉その他の権利または利益を侵害する行為</p>
                        <p class="mb-2">（10）掲載車両等情報に虚偽の内容を掲載する行為</p>
                        <p class="mb-2">（11）掲載者が所有権を有しない等、売却する権限のない物品を掲載する行為、または他の人物や組織と提携、協力関係にあると偽ったりする行為</p>
                        <p class="mb-2">（12）本サービスを利用して掲載車両等とは関係のない商品・サービスの営業、宣伝、広告、勧誘、その他営利を目的とする行為（当社の認めたものを除きます。）、宗教活動または宗教団体への勧誘行為、性行為やわいせつな行為を目的とする行為、面識のない異性との出会いや交際を目的とする行為、児童ポルノまたは児童虐待に相当する情報を表示しまたは表示させる行為、第三者に対する嫌がらせや誹謗中傷を目的とする行為、その他本サービスが予定している利用目的と異なる目的で本サービスを利用する行為</p>
                        <p class="mb-2">（13）サービス利用者間における本サービスを介さずに行う直接取引またはそれを勧誘する行為</p>
                        <p class="mb-2">（14）本ウェブサイトおよび本サービスを利用して、他のサービス利用者を自己または第三者のウェブサイトに誘導する等の行為</p>
                        <p class="mb-2">（15）本サービスのサーバーやネットワークシステムに支障を与える行為、BOT、チートツール、その他の技術的手段を利用してサービスを不正に操作する行為、本サービスの不具合を意図的に利用する行為、類似または同様の問い合わせを必要以上に繰り返す等の行為、当社に対し不当な要求をする行為、ウイルス等の有害なコンピュータプログラム等を送信または掲載する行為、その他当社による本サービスの運営または第三者によるサービスの利用を妨害し、これらに支障を与える行為</p>
                        <p class="mb-2">（16）自ら本サービスと競合するサービスを行うこと</p>
                        <p class="mb-2">（17）上記（1）から（16）のいずれかに該当する行為を援助または助長する行為</p>
                        <p class="mb-2">（18）その他、当社が不適切と判断する行為</p>
                        <p class="mb-2">2．サービス利用者が前項各号にあたる行為を行ったと当社が判断した場合、当社は、サービス利用者に事前に通知することなく、それらの行為に該当する掲載車両等情報の全部または一部を削除すること、およびそれらの行為を行ったサービス利用者に対し、本サービスの利用を一時的に停止すること、掲載者と問い合わせ会員の間の交渉を目的とした氏名、住所、電話番号、メールアドレス等の個人情報の開示、その他当社が必要と判断する措置を取ることができるものとします。ただし、当社は、法令上の求めがある場合を除き、上記措置を行う義務を負いません。</p>
                        <p class="mb-2">3．当社は、本条に基づき当社が行った措置により、サービス利用者に生じた損害について、理由を問わず一切の責任を負いません。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第12条（本サービスの提供の停止等）</p>
                        <p class="mb-2">1．当社は、以下のいずれかの事由に該当すると判断した場合には、サービス利用者に事前に通知することなく本サービスの全部または一部（仕様、ルール、デザイン、視聴覚的表現、その他一切の事項を含みます。）の提供を停止することができるものとします。</p>
                        <p class="mb-2">（1）本サービスにかかるコンピュータシステムの点検または保守作業を定期的または緊急に行う場合</p>
                        <p class="mb-2">（2）本サービスにかかるコンピュータシステムの障害、本サービスの連携サービス等のトラブル・サービス提供停止・廃止、その他本サービスの提供に必要な設備の障害等により本サービスの提供が困難となった場合</p>
                        <p class="mb-2">（3）コンピュータまたは通信回線等が事故により停止した場合</p>
                        <p class="mb-2">（4）地震、落雷、火災、停電または天災などの不可抗力により、本サービスの提供が困難となった場合</p>
                        <p class="mb-2">（5）法令等に基づく措置により本サービスの提供ができないとき</p>
                        <p class="mb-2">（6）その他、当社が本サービスの提供が困難と判断した場合</p>
                        <p class="mb-2">2．当社は、本条に基づき当社が行った措置によりサービス利用者または第三者に生じた損害について、理由を問わず一切の責任を負いません。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第13条（本サービス内容の変更）</p>
                        <p class="mb-2">1．当社は、サービス利用者に事前に何ら通知することなく、当社の都合により、本サービスの全部または一部（仕様、ルール、デザイン、視聴覚的表現、その他一切の事項を含みます。）の内容を変更することができるものとします。</p>
                        <p class="mb-2">2．当社は、本サービスの内容の変更をするときは、事前または事後に当社の定める方法によりサービス利用者にその旨を通知するよう努めるものとします。</p>
                        <p class="mb-2">3．当社は、本条に基づき当社が行った措置に基づきサービス利用者および第三者に生じた損害について、理由を問わず一切の責任を負いません。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第14条（本サービスの終了）</p>
                        <p class="mb-2">1．当社は、当社の都合によって、当社の判断で本サービスの提供を終了することができます。この場合、当社はサービス利用者に事前に通知するものとします。</p>
                        <p class="mb-2">2．当社は、本条に基づき当社が行った措置に基づきサービス利用者および第三者に生じた損害について、理由を問わず一切の責任を負いません。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第15条（利用制限および登録抹消）</p>
                        <p class="mb-2">1．当社は、サービス利用者が、以下の各号のいずれかの事由に該当する場合には、事前に通知または催告することなく、当該サービス利用者について本サービスの利用の一時的停止、または、サービス利用者としての登録の抹消、もしくはサービス利用契約の解除をすることができるものとします。</p>
                        <p class="mb-2">（1）本規約のいずれかの条項に違反した場合</p>
                        <p class="mb-2">（2）登録情報に虚偽の事実があることが判明した場合</p>
                        <p class="mb-2">（3）サービス利用者が、死亡した場合または後見開始、保佐開始もしくは補助開始の審判を受けた場合</p>
                        <p class="mb-2">（4）手段の如何を問わず、本サービスの運営を妨害した場合</p>
                        <p class="mb-2">（5）サービス利用者が、破産、民事再生、会社更生または特別清算の手続開始決定等の申立がなされたとき</p>
                        <p class="mb-2">（6）当社からの問い合わせその他の回答を求める連絡に対して30日間以上返答がない場合</p>
                        <p class="mb-2">（7）第6条（利用登録）第4項各号に該当する場合</p>
                        <p class="mb-2">（8）その他、当社が本サービスの利用、サービス利用者としての登録、またはサービス利用契約の継続を適当でないと判断した場合</p>
                        <p class="mb-2">2．前項各号のいずれかに該当し、サービス利用者としての登録の抹消、またはサービス利用契約の解除が行われた場合、サービス利用者が掲載者として掲載した掲載車両等情報は、当社により本サービスから削除されるものとします。</p>
                        <p class="mb-2">3．当社は、本条に基づき当社が行った措置によりサービス利用者または第三者に生じた損害について、理由を問わず一切の責任を負いません。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第16条（反社会的勢力の排除）</p>
                        <p class="mb-2">1．サービス利用者は、サービス利用者、その親会社・子会社等の関係会社、ならびにサービス利用者の役員・従業員等が次の各号に該当する場合には、本サービスを利用することができないものとします。</p>
                        <p class="mb-2">（1）反社会的勢力（暴力団、暴力団員、暴力団員でなくなった時から５年を経過しない者、暴力団準構成員、暴力団関係企業、総会屋、社会運動標ぼうゴロまたは特殊知能暴力集団、その他これらに準ずる者をいう。）であること</p>
                        <p class="mb-2">（2）反社会的勢力等が経営を支配していると認められる関係を有すること</p>
                        <p class="mb-2">（3）反社会的勢力等が経営に実質的に関与していると認められる関係を有すること</p>
                        <p class="mb-2">（4）自己、自社若しくは第三者の不正の利益を図る目的又は第三者に損害を加える目的をもってするなど、不当に反社会的勢力等を利用していると認められる関係を有すること</p>
                        <p class="mb-2">（5）反社会的勢力等に対して暴力団員等であることを知りながら資金等を提供し、又は便宜を供与するなどの関与をしていると認められる関係を有すること</p>
                        <p class="mb-2">（6）その他反社会的勢力等と社会的に非難されるべき関係を有すること</p>
                        <p class="mb-2">2.自らまたは第三者を利用して、以下の行為を行ったこと</p>
                        <p class="mb-2">①暴力的な要求行為</p>
                        <p class="mb-2">②法的な責任を超えた不当な要求行為</p>
                        <p class="mb-2">③取引に関して脅迫的な言動をし、または暴力を用いる行為</p>
                        <p class="mb-2">④風説の流布、偽計、威力を用いて当社の信用を毀損しまたは当社の業務を妨害する行為</p>
                        <p class="mb-2">⑤その他前各号に準ずる行為</p>
                        <p class="mb-2">3．サービス利用者は、本サービスを利用することにより、前項各号のいずれにも該当していないことを表明保証したものとみなされるものとします。</p>
                        <p class="mb-2">4．サービス利用者は、前項の表明保証に違反したことにより当社が被った損害を賠償するものとします。</p>
                        <p class="mb-2">5.サービス利用者が本条に違反した場合には、当社は、催告その他の手続を要しないで、直ちにサービス利用者としての登録の抹消、またはサービス利用契約を解除できるものとします。</p>
                        <p class="mb-2">6.当社は、前項に基づく登録抹消・解除によりサービス利用者に損害が生じた場合であっても、当該損害の賠償義務を負わないものとします。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第17条（退会）</p>
                        <p class="mb-2">1．サービス利用者は、当社所定の方法により、本サービスから退会し、サービス利用者としての登録を抹消することができます。本項に定める退会を行ったときには、サービス利用契約は解除され、サービスの利用を継続することはできません。</p>
                        <p class="mb-2">2．退会後のサービス利用者の個人情報と登録情報の取扱いについては、第20条（個人情報等の取扱い）の規定に従うものとします。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第18条（権利帰属）</p>
                        <p class="mb-2">1．本ウェブサイト等および本サービスに関する所有権および知的財産権は全て当社または当社にライセンスを許諾している者に帰属しており、サービス利用契約に基づく本サービスの利用許諾は、本ウェブサイト等または本サービスに関する当社または当社にライセンスを許諾している者の知的財産権の使用許諾を意味するものではありません。</p>
                        <p class="mb-2">2．サービス利用者は、本サービスを通じて自らが投稿および送信を行った文章、画像、動画その他のデータ（以下、「コンテンツ」といいます。）について、投稿または送信することについての適法な権利を有していること、および第三者の権利を侵害していないことについて、当社に対し表明し、保証するものとします。</p>
                        <p class="mb-2">3．サービス利用者は、本サービスを通じて自らが投稿および送信したコンテンツについて、投稿または送信を行ったときに、当社に対し、無償および無制限の利用許諾を行うものとし、当社は、当該コンテンツを本サービスにおいて利用すること、および本サービスに関する広告（パンフレット、チラシ、雑誌等の紙媒体やインターネット等の電子媒体等）に掲載することができるものとします。なお、サービス利用者が退会及び登録抹消となった場合であっても、それ以前に提供した情報の権利は本項によるものとします。</p>
                        <p class="mb-2">4．サービス利用者は、当社および当社から権利を承継または許諾された者に対して著作者人格権を行使しないことに同意するものとします。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第19条（保証の否認および免責事項）</p>
                        <p class="mb-2">1．当社は、本サービスがサービス利用者の特定の利用目的に適合すること、期待する機能・商品的価値・正確性・有用性を有すること、サービス利用者による本サービスの利用がサービス利用者に適用のある法令または業界団体の内部規則等に適合すること、および不具合が生じないことについて、何ら保証するものではありません。</p>
                        <p class="mb-2">2．本ウェブサイト等から第三者のウェブサイトへのリンクが提供されている場合、または第三者のウェブサイトから本ウェブサイト等へのリンクが提供されている場合といえども、当社は、本ウェブサイト等以外の第三者ウェブサイトにおける情報に関して、何ら保証するものではなく、理由を問わず一切の責任を負いません。</p>
                        <p class="mb-2">3．当社は、本サービスに起因して本サービス内および本サービス外において、サービス利用者間にトラブルがあった場合には、当該トラブルは当事者間で解決するものとし、当社は当該トラブルに関して、理由を問わず一切の責任を負いません。</p>
                        <p class="mb-2">4．当社は、本サービスに起因してサービス利用者に生じたあらゆる損害につき、賠償する責任を一切負わないものとします。ただし、当社に故意または重過失がある場合、またはサービス利用契約が消費者契約法に定める消費者契約に該当する場合には、本項は適用しないものとします。</p>
                        <p class="mb-2">5．当社が、本サービスの利用に関し、損害賠償責任を負う場合には、本サービスに起因してサービス利用者に生じた直接かつ通常の損害に限るものとします。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第20条（個人情報等の取扱い）</p>
                        <p class="mb-2">1．当社は、本ウェブサイトで取得したサービス利用者の個人情報等を、当社の定める個人情報に関する基本方針（<a href="https://www.steerlink.co.jp/privacy.php" class="text-blue-500 hover:text-blue-800">https://www.steerlink.co.jp/privacy.php</a>）に従い、適正かつ安全に管理・運用します。サービス利用者は、当社が、当該個人情報に関する基本方針に従って、サービス利用者の個人情報等を取扱うことについて同意するものとします。</p>
                        <p class="mb-2">2．当社は、本ウェブサイトでサービス利用者が当社に提供した個人情報等を、以下の各号に定める利用目的のみに利用します。その他の目的に利用することはありません。</p>
                        <p class="mb-2">①サービス利用者が掲載した商品、購入した商品の内容やサービス利用者の本ウェブサイトでの売買取引内容を確認・取消・連絡するために、サービス利用者の個人情報等と売買された商品の種類や数量、取引金額などの情報を利用します。 </p>
                        <p class="mb-2">②サービス利用者が取消を希望した取引の返金作業を実施するために、サービス利用者の個人情報等と売買された商品の種類や数量、取引金額などの情報を利用します。</p>
                        <p class="mb-2">③サービス利用者に本ウェブサイトが行うキャンペーンや商品・サービスのご案内をするために、購入履歴や、サービス利用者の個人情報等を利用します。 </p>
                        <p class="mb-2">④本ウェブサイトのサービス改善を行うために、サービス利用者から寄せられたご意見やアンケートの結果、購入履歴などを利用します。 </p>
                        <p class="mb-2">⑤サービス利用者からのご要望、お問い合わせに対する回答をするために、サービス利用者の個人情報等を利用します。 </p>
                        <p class="mb-2">3. 当社は、クッキー（Cookie）およびその他のトラッキング技術（例えばWebビーコン）を使用して、IPアドレス等の識別子を含む、サービス利用者の本ウェブサイトにおけるアクセス履歴および利用状況に関する情報を収集します。当社は、これらの情報を、本ウェブサイトの機能を安全かつ円滑に動作させるため、また、サービス利用者の希望する設定に関する情報を当社が取得するために使用します。</p>
                        <p class="mb-2">4. 当社は、本ウェブサイトで取得した個人情報等を、個人情報保護法その他関連法令により認められる場合を除き、個人情報等の登録者の同意を得ずに第三者に提供しません。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第21条（有効期間）</p>
                        <p class="mb-2">当社とサービス利用者との本サービスのサービス利用契約は、本サービスの提供期間中、第6条（利用登録）に基づく利用登録が完了した日から、当該サービス利用者のサービス利用者としての登録が抹消、退会またはサービス利用契約が解除される日もしくは本サービスの提供が終了する日まで、当社とサービス利用者との間で有効に存続するものとします。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第22条（通知または連絡）</p>
                        <p class="mb-2">1．本サービスに関する当社からサービス利用者への通知または連絡は、本ウェブサイトへの掲示、その他当社の定める方法によって行うものとします。</p>
                        <p class="mb-2">2．本サービスに関するサービス利用者から当社への通知または連絡は、本ウェブサイトに設置するお問い合わせフォームの送信またはその他当社の定める方法によって行うものとします。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第23条（サービス利用契約上の地位の譲渡等）</p>
                        <p class="mb-2">1．サービス利用者は、当社からの書面による事前の承諾なく、サービス利用契約上の地位または本規約に基づく権利もしくは義務につき、第三者に対し、譲渡、移転、担保設定、その他の処分をすることはできません。</p>
                        <p class="mb-2">2．当社は、本サービスにかかる事業を他社に譲渡した場合には、当該事業譲渡に伴いサービス利用契約上の地位、本規約に基づく権利および義務ならびにサービス利用者の登録情報その他の情報を当該事業譲渡の譲受人に譲渡することができるものとし、サービス利用者は、かかる譲渡につき本項において予め同意したものとします。なお、本項に定める事業譲渡には、通常の事業譲渡のみならず、会社分割その他事業が移転するあらゆる場合を含むものとします。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第24条（損害賠償）</p>
                        <p class="mb-2">サービス利用者は、本規約に違反することにより、または本サービスの利用に関連して当社に損害を与えた場合および第三者に損害を与え当社がその第三者からの損害賠償を求められた場合、当社に対し当該損害を賠償しなければなりません。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第25条（分離可能性）</p>
                        <p class="mb-2">本規約のいずれかの条項またはその一部が、法令等により無効または執行不能と判断された場合であっても、本規約の残りの規定および一部が無効または執行不能と判断された規定の残りの部分は、継続して完全に効力を有するものとします。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第26条（準拠法・裁判管轄）</p>
                        <p class="mb-2">1．本規約の準拠法は日本法とします。</p>
                        <p class="mb-2">2．本規約に関連する一切の紛争については、千葉地方裁判所を第一審の専属的合意管轄裁判所とします。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">第27条（協議解決）</p>
                        <p class="mb-2">当社およびサービス利用者は、本規約に定めのない事項または本規約の解釈に疑義が生じた場合には、互いに信義誠実の原則に従って協議の上速やかに解決を図るものとします。</p>
                      </div>

                      <div class="mb-8">
                        <p class="mb-2 font-semibold">2022年2月18日制定</p>
                      </div>
                    </div>
                  </div>
                  <v-check-box
                    v-model="policy"
                    label="アイナビトラック 無料会員利用規約に同意する"
                    help=""
                    vid="policy"
                    name="無料会員利用規約"
                    :rules="{ required: { allowFalse: false } }"
                    input-class="checkbox-md"
                    :is-center="true"
                  ></v-check-box>
                </div>
                <div class="hidden md:flex justify-center mt-16 text-center w-full">
                  <button
                    type="button"
                    class="btn btn-outline-primary btn-lg btn-wide rounded btn-icon md:mt-0 mt-5 mr-5 w-full md:w-auto"
                    @click="
                      step = 1
                      policy = ''
                    "
                  >
                    入力に戻る <i class="fa fa-arrow-left left"></i>
                  </button>
                  <button type="submit" class="btn btn-primary btn-lg btn-wide rounded btn-icon w-full md:w-auto">
                    会員登録 <i class="fa fa-arrow-right"></i>
                  </button>
                </div>
                <div class="md:hidden justify-center mt-16 text-center grid-cols-12">
                  <button type="submit" class="btn btn-primary btn-lg btn-wide rounded btn-icon w-full md:w-auto">
                    会員登録 <i class="fa fa-arrow-right"></i>
                  </button>
                  <button
                    type="button"
                    class="btn btn-outline-primary btn-lg btn-wide rounded btn-icon md:mt-0 mt-5 w-full md:w-auto"
                    @click="
                      step = 1
                      policy = ''
                    "
                  >
                    入力に戻る <i class="fa fa-arrow-left left"></i>
                  </button>
                </div>
              </form>
            </ValidationObserver>
          </div>

          <!-- FORM SUCCESS -->
          <div v-if="step === 3" key="form-3">
            <p class="text-center leading-loose">
              会員登録が完了いたしました。 <br />
              ご入力頂いたメールアドレス宛てに送信したメールをご確認ください。 <br />
              また、担当者からご連絡させて頂きます。
            </p>
            <div class="grid grid-cols-12 gap-4 mt-8">
              <label class="col-span-12 lg:col-span-4"></label>
              <div class="col-span-12 text-center">
                <a href="/login" class="btn btn-primary btn-lg btn-wide rounded btn-icon w-full md:w-auto">
                  マイページへ <i class="fa fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        </transition-group>
      </div>
    </div>
  </div>
</template>

<script>
import AttributeShow from '../../components/AttributeShow'
export default {
  name: 'RegisterForm',
  components: { AttributeShow },
  props: {
    businessForm: {
      type: [Array, Object, String],
      required: true,
    },
    prefectureForm: {
      type: [Array, Object, String],
      required: true,
    },
  },
  data() {
    return {
      step: 1,
      firstName: '',
      lastName: '',
      phone: '',
      email: '',
      password: '',
      passwordConfirmation: '',
      businessType: '',
      zipcode: '',
      address: '',
      city: '',
      prefecture: '',
      companyName: '',
      policy: '',
    }
  },
  computed: {
    optionsBusiness() {
      if (typeof this.businessForm === 'string') {
        try {
          return JSON.parse(this.businessForm)
        } catch (e) {
          console.log(e)
          return []
        }
      }
      return this.businessForm
    },
    optionsPrefecture() {
      if (typeof this.prefectureForm === 'string') {
        try {
          return JSON.parse(this.prefectureForm)
        } catch (e) {
          console.log(e)
          return []
        }
      }
      return this.prefectureForm
    },
  },
  methods: {
    onSubmit() {
      if (this.isCallingApi) {
        return
      }

      const params = this.getFormParams()

      this.isCallingApi = true
      this.$api
        .postRegister(
          params,
          success => {
            this.step = 2
          },
          error => {
            this.showValidateError(error)
          }
        )
        .finally(() => {
          this.isCallingApi = false
        })
    },
    onSubmitConfirm() {
      if (this.isCallingApi) {
        return
      }

      const params = this.getFormParams()
      params.confirm = true
      this.isCallingApi = true

      this.$api
        .postRegister(
          params,
          success => {
            this.step = 3
          },
          error => {
            this.step = 1
            this.showValidateError(error)
          }
        )
        .finally(() => {
          this.isCallingApi = false
        })
    },
    getFormParams() {
      return {
        email: this.email,
        password: this.password,
        password_confirmation: this.passwordConfirmation,
        first_name: this.firstName,
        last_name: this.lastName,
        business_type: this.businessType,
        zipcode: this.zipcode,
        address: this.address,
        company_name: this.companyName,
        prefecture: this.prefectureForm[this.prefecture],
        city: this.city,
        phone: this.phone,
      }
    },
  },
}
</script>
