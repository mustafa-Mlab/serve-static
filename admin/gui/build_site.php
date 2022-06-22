<?php 
  /* Check is diirectory exist otherwise create your own directories */

  $filestructures =['root'=> get_option('static_path',  ABSPATH ), 'asset' => 'img', 'styles'=> 'css', 'js' => 'js', 'localfolder' => get_option( 'localfolder', 'dist' )];
  $localFolderPath = explode('/', $filestructures['localfolder']);
  $root = $filestructures['root'];
  foreach( $localFolderPath as $id => $folder){
    if (!file_exists($folder)) {
      mkdir($root .  $folder, 0777);
      echo "The directory ".$folder . " was successfully created.<br>";
    } else {
      echo "The directory ".$folder . " exists.<br>";
    }
    $root = $root . $folder . '/';
  }
  $subFolderName = get_option('subfolder-name',  '' );
  // $allUrls = array(
  //     'https://dev-test.monstar-lab.com/bd/ml-news/monstarlab-enters-into-agreement-to-acquire-ecap-expects-to-extend-end-to-end-digital-transformation-services-in-mena-region/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/health-insurance-companies-are-turning-a-corner/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/monstarlab-opens-new-office-in-poland-boosts-delivery-excellence/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/monstarlab-announces-sunny-vashishtha-as-new-svp-global-delivery/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/monstarlab-promotes-kasper-heumann-kristensen-to-cfo-coo-emea-ramping-up-its-focus-on-operational-excellence/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/damage-due-to-fragmented-it-systems/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/machine-learning-for-fleet-management/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/izumo_dx_210818/',
  //     'https://dev-test.monstar-lab.com/bd/cases/social-platform-for-reporting-transport-issues/',
  //     'https://dev-test.monstar-lab.com/bd/cases/national-cab-booking-platform/',
  //     'https://dev-test.monstar-lab.com/bd/cases/one-tap-cab-dispatch-app/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/product-owners-vs-product-managers-train-drivers-and-track-builders/',
  //     'https://dev-test.monstar-lab.com/bd/experts/simon-ejsing-tl/',
  //     'https://dev-test.monstar-lab.com/bd/cases/leveraging-technology-to-upgrade-dental-care-routines/',
  //     'https://dev-test.monstar-lab.com/bd/thoughtleadership/moving-transportation-logistics-forward-with-technology/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/retail-2030-the-tech-strategy-to-power-retail-brands-into-the-future-white-paper/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/mobile-apps-transforming-transportation/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/technology-driving-change-in-the-transport-logistics-industry/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/how-transport-and-logistics-companies-can-kickstart-low-risk-digital-transformation/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/the-distinct-impact-of-big-data-analytics-in-transport-logistics/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/xid_201709/',
  //     'https://dev-test.monstar-lab.com/bd/cases/inspiring-digital-transformation-and-positive-customer-engagement/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/mark_210701/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/hr_210630/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/hdhr_210630/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/the-pitfalls-of-doing-agile-versus-being-agile/',
  //     'https://dev-test.monstar-lab.com/bd/experts/tobias-morville-tl/',
  //     'https://dev-test.monstar-lab.com/bd/experts/luke-gallimore-tl/',
  //     'https://dev-test.monstar-lab.com/bd/experts/simon-ejsing/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/hd_210624/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/210615_intloop/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/210604_mlhub/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/5-changes-life-science-companies-are-making-in-their-digital-strategy/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/bxc_210603/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/210602_mlm/',
  //     'https://dev-test.monstar-lab.com/bd/cases/amplifying-market-penetration-through-itof-and-ar-technology/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/mlbx_210601/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/emerging-trend-mini-programs-what-it-means-for-global-brands/',
  //     'https://dev-test.monstar-lab.com/bd/cases/empowering-patients-and-professionals-with-transformative-technology/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/behavioral-science-integrations-changing-the-game-in-digital-patient-care/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/successful-digital-product-delivery-in-times-of-rapid-technological-development/',
  //     'https://dev-test.monstar-lab.com/bd/cases/kerzner/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/the-3cs-your-quality-management-partner-should-possess/',
  //     'https://dev-test.monstar-lab.com/bd/thoughtleadership/revitalizing-wholesale-retail-ecommerce-for-the-next-normal/',
  //     'https://dev-test.monstar-lab.com/bd/cases/using-ai-technology-to-mitigate-costly-returns/',
  //     'https://dev-test.monstar-lab.com/bd/experts/daniel-kalick/',
  //     'https://dev-test.monstar-lab.com/bd/experts/4784/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/maximise-stores-in-the-digital-retail-experience/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/leverage-data-analytics-to-avoid-the-next-big-disruption/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/platforms-explained-for-retailers-shifting-to-d2c/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/3-reasons-why-your-ecommerce-is-struggling/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/digital-trends-driving-wholesale-retail-ecommerce-into-the-next-normal/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/the-life-science-sectors-ability-to-innovate-remains-restricted-by-outdated-incentive-structures/',
  //     'https://dev-test.monstar-lab.com/bd/about/youjie-zhang/',
  //     'https://dev-test.monstar-lab.com/bd/about/glenn-mindegaard-post/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/how-stores-can-drive-business-in-the-next-normal/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/glenn-mindegaard-post/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/peter-busk/',
  //     'https://dev-test.monstar-lab.com/bd/experts/rasmus-mortensen/',
  //     'https://dev-test.monstar-lab.com/bd/experts/daisuke-hirata/',
  //     'https://dev-test.monstar-lab.com/bd/experts/sarah-bui/',
  //     'https://dev-test.monstar-lab.com/bd/experts/4705/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/what-is-an-mvp-a-global-perspective/',
  //     'https://dev-test.monstar-lab.com/bd/about/board-of-directors/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/hrannouncement_210331/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/product-analytics-tracking-plans/',
  //     'https://dev-test.monstar-lab.com/bd/board-of-directors/yoshihiro-nakahara/',
  //     'https://dev-test.monstar-lab.com/bd/board-of-directors/bryan-macdonald/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/youjie-zhang/',
  //     'https://dev-test.monstar-lab.com/bd/leadership/hiroshi-osada/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/3-technologies-your-healthcare-app-should-have/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/why-agile-teams-should-play-chess/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/monstarlab-2021-part-iii-from-dna-to-visual-identity/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/monstarlab-2021-part-ii-the-works/',
  //     'https://dev-test.monstar-lab.com/bd/board-of-directors/masahiko-matsunaga/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/monstarlab-2021-part-i-driving-global-unity/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/life-science-technology-%e2%80%a8-in-2021/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/brandintegration_210304/',
  //     'https://dev-test.monstar-lab.com/bd/board-of-directors/ryuichi-tomimura/',
  //     'https://dev-test.monstar-lab.com/bd/board-of-directors/nobuhiro-asada/',
  //     'https://dev-test.monstar-lab.com/bd/board-of-directors/akenobu-hayakawa/',
  //     'https://dev-test.monstar-lab.com/bd/board-of-directors/hitoshi-takabatake/',
  //     'https://dev-test.monstar-lab.com/bd/board-of-directors/yasuhiro-mimura/',
  //     'https://dev-test.monstar-lab.com/bd/board-of-directors/toshitada-nagumo/',
  //     'https://dev-test.monstar-lab.com/bd/board-of-directors/toshihito-nagai/',
  //     'https://dev-test.monstar-lab.com/bd/board-of-directors/daisuke-kaihoku/',
  //     'https://dev-test.monstar-lab.com/bd/board-of-directors/hiroki-inagawa/',
  //     'https://dev-test.monstar-lab.com/bd/board-of-directors/fumiaki-goto/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/cpo_210301/',
  //     'https://dev-test.monstar-lab.com/bd/leadership/sharon-kelly/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/ciupdate_210225/',
  //     'https://dev-test.monstar-lab.com/bd/leadership/nick-constantinou/',
  //     'https://dev-test.monstar-lab.com/bd/leadership/max-oglesbee/',
  //     'https://dev-test.monstar-lab.com/bd/cases/raising-home-comfort-to-new-levels-with-iot-technology/',
  //     'https://dev-test.monstar-lab.com/bd/cases/realising-iot-based-telemedicine-management/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/the-state-of-banking-2020-dangerously-close-to-digital-paralyzation/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/track-trace-unpacking-its-meaning-and-future-potential/',
  //     'https://dev-test.monstar-lab.com/bd/experts/alexander-holdsworth/',
  //     'https://dev-test.monstar-lab.com/bd/experts/tobias-lund-eskerod/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/learning-from-other-industries-to-revitalise-cx-in-life-science/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/creating-a-seamless-digital-experience-for-patients/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/top-tech-challenges-life-science-enterprises-face-and-how-to-approach-them/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/pharma-forward-digital-innovations-revolutionising-the-industry/',
  //     'https://dev-test.monstar-lab.com/bd/cases/mashreq/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/data-driven-organisation-leading-practice/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/how-to-get-ahead-during-a-crisis-leading-through-digital-innovation/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/how-to-level-up-your-product-team-the-three-ps/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/how-to-think-like-a-product-manager-overcoming-cognitive-bias/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/how-do-you-measure-the-roi-of-great-design/',
  //     'https://dev-test.monstar-lab.com/bd/thoughtleadership/empowering-life-science-in-the-digital-era/',
  //     'https://dev-test.monstar-lab.com/bd/experts/morten-faarkrog/',
  //     'https://dev-test.monstar-lab.com/bd/experts/youjie-zhang-bio/',
  //     'https://dev-test.monstar-lab.com/bd/service/infrastructure-cloud/',
  //     'https://dev-test.monstar-lab.com/bd/service/web-development/',
  //     'https://dev-test.monstar-lab.com/bd/service/tech-consultancy/',
  //     'https://dev-test.monstar-lab.com/bd/service/digital-factory/',
  //     'https://dev-test.monstar-lab.com/bd/service/digital-strategy-and-transformation/',
  //     'https://dev-test.monstar-lab.com/bd/service/qa/',
  //     'https://dev-test.monstar-lab.com/bd/service/experience-platforms/',
  //     'https://dev-test.monstar-lab.com/bd/service/innovation-squad/',
  //     'https://dev-test.monstar-lab.com/bd/service/chinese-localisation/',
  //     'https://dev-test.monstar-lab.com/bd/service/sitecore/',
  //     'https://dev-test.monstar-lab.com/bd/service/data-analytics-strategy-and-transformation/',
  //     'https://dev-test.monstar-lab.com/bd/service/artificial-intelligence/',
  //     'https://dev-test.monstar-lab.com/bd/service/mobile-app-development/',
  //     'https://dev-test.monstar-lab.com/bd/service/design-and-cx/',
  //     'https://dev-test.monstar-lab.com/bd/service/product-management/',
  //     'https://dev-test.monstar-lab.com/bd/service/stay-ahead-of-the-disruptors/',
  //     'https://dev-test.monstar-lab.com/bd/service/accelerate-a-startup-or-sme/',
  //     'https://dev-test.monstar-lab.com/bd/service/blend-physical-and-digital-experiences/',
  //     'https://dev-test.monstar-lab.com/bd/service/enable-a-mobile-workforce/',
  //     'https://dev-test.monstar-lab.com/bd/service/create-compelling-user-experiences/',
  //     'https://dev-test.monstar-lab.com/bd/service/modernise-core-services/',
  //     'https://dev-test.monstar-lab.com/bd/service/foster-a-digital-culture-and-capability/',
  //     'https://dev-test.monstar-lab.com/bd/service/unlock-value-from-data/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/mlvietnam_200115/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/ideas-for-an-effective-digital-transformation-strategy/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/the-hidden-parts-of-the-journey-how-to-discover-customer-problems-worth-solving-2/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/reduce-risk-in-your-product-development-with-hypothesis-driven-design-2/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/machine-learning-in-insurance-empowering-executives-to-drive-better-business-decisions-2/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/how-to-reduce-product-debt-by-solving-the-fail-fast-problem-2/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/how-great-product-managers-make-better-decisions-a-habitual-approach-2/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/3480/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/when-to-use-the-design-sprint-and-when-not-to-2/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/how-employee-apps-are-the-backbone-of-successful-enterprises/',
  //     'https://dev-test.monstar-lab.com/bd/who-we-are/',
  //     'https://dev-test.monstar-lab.com/bd/service/agile-enterprise-delivery/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/innovation-in-the-supply-chain/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/how-to-manage-your-product-throughout-its-life-cycle/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/how-to-build-a-healthy-product-roadmap-foundational-principles/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/changing-the-game-of-financial-services-through-cx-transformation/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/how-we-organise-and-empower-our-global-design-team-with-internal-sprints-in-jira/',
  //     'https://dev-test.monstar-lab.com/bd/cases/snack-by-income/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/usability-testing-and-how-to-convince-your-stakeholders/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/designing-for-hospitality-7-tips-for-creating-digital-and-physical-experiences-that-make-us-feel-welcome/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/how-to-be-a-great-product-manager-enterprise-vs-startup/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/how-to-define-a-product-strategy-the-value-based-approach/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/the-future-of-iot-security-and-privacy-focused/',
  //     'https://dev-test.monstar-lab.com/bd/cases/cbre/',
  //     'https://dev-test.monstar-lab.com/bd/cases/chr-hansen/',
  //     'https://dev-test.monstar-lab.com/bd/cases/shake-shack-2/',
  //     'https://dev-test.monstar-lab.com/bd/cases/koubei-alibaba/',
  //     'https://dev-test.monstar-lab.com/bd/cases/zo/',
  //     'https://dev-test.monstar-lab.com/bd/cases/abi/',
  //     'https://dev-test.monstar-lab.com/bd/cases/tulerie/',
  //     'https://dev-test.monstar-lab.com/bd/cases/potbelly/',
  //     'https://dev-test.monstar-lab.com/bd/cases/fujitsu-2/',
  //     'https://dev-test.monstar-lab.com/bd/cases/e-boks/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/ml-vietnam-donated_201228/',
  //     'https://dev-test.monstar-lab.com/bd/cases/gls/',
  //     'https://dev-test.monstar-lab.com/bd/cases/danske-bank/',
  //     'https://dev-test.monstar-lab.com/bd/cases/tempur/',
  //     'https://dev-test.monstar-lab.com/bd/cases/top-of-the-rock/',
  //     'https://dev-test.monstar-lab.com/bd/cases/dot/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/funds_201208/',
  //     'https://dev-test.monstar-lab.com/bd/experts/tobias-morville/',
  //     'https://dev-test.monstar-lab.com/bd/experts/luke-gallimore/',
  //     'https://dev-test.monstar-lab.com/bd/thoughtleadership/the-future-of-banking-financial-services-and-insurance/',
  //     'https://dev-test.monstar-lab.com/bd/thoughtleadership/expertinsights/',
  //     'https://dev-test.monstar-lab.com/bd/thoughtleadership/',
  //     'https://dev-test.monstar-lab.com/bd/cases/careem-now/',
  //     'https://dev-test.monstar-lab.com/bd/ceo-column/the-story-of-nodes-and-monstarlab/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/hr_cgo_201001/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/new_colombia_office/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/fund_200807/',
  //     'https://dev-test.monstar-lab.com/bd/leadership/mark-jones/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/announcement_20200605/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/csco_200601/',
  //     'https://dev-test.monstar-lab.com/bd/cases/kubota/',
  //     'https://dev-test.monstar-lab.com/bd/cases/the-kagoshima-bank/',
  //     'https://dev-test.monstar-lab.com/bd/cases/hitachi-gls/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/globalcfo200501/',
  //     'https://dev-test.monstar-lab.com/bd/leadership/yoshihiro-nakahara/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/ft_200421/',
  //     'https://dev-test.monstar-lab.com/bd/ceo-column/shifting-sands-the-coming-boom-in-technology-and-talent-in-the-middle-east-part-two/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/regarding-the-appointment-of-directors-auditors-and-adviser_200331/',
  //     'https://dev-test.monstar-lab.com/bd/ceo-column/shifting-sands-part-one/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/news_20200131/',
  //     'https://dev-test.monstar-lab.com/bd/expertinsights/four-technology-trends-that-will-shape-the-financial-sector-in-2020/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/myboss_join/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/new-website/',
  //     'https://dev-test.monstar-lab.com/bd/cases/scandlines/',
  //     'https://dev-test.monstar-lab.com/bd/cases/survey-monkey/',
  //     'https://dev-test.monstar-lab.com/bd/ceo-column/be-borderless/',
  //     'https://dev-test.monstar-lab.com/bd/cases/toranotec/',
  //     'https://dev-test.monstar-lab.com/bd/cases/met/',
  //     'https://dev-test.monstar-lab.com/bd/cases/trygroup/',
  //     'https://dev-test.monstar-lab.com/bd/leadership/hiroki-inagawa/',
  //     'https://dev-test.monstar-lab.com/bd/leadership-details/',
  //     'https://dev-test.monstar-lab.com/bd/thank-you/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/fuzz_join/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/new_office_in_dubai/',
  //     'https://dev-test.monstar-lab.com/bd/cookie-policy/',
  //     'https://dev-test.monstar-lab.com/bd/terms/',
  //     'https://dev-test.monstar-lab.com/bd/privacy/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/global_evp/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/naos_wilbrinks_joins/',
  //     'https://dev-test.monstar-lab.com/bd/about/news/',
  //     'https://dev-test.monstar-lab.com/bd/404/',
  //     'https://dev-test.monstar-lab.com/bd/about/news/page/2/',
  //     'https://dev-test.monstar-lab.com/bd/about/careers/',
  //     'https://dev-test.monstar-lab.com/bd/about/ceo-column/',
  //     'https://dev-test.monstar-lab.com/bd/about/leadership/',
  //     'https://dev-test.monstar-lab.com/bd/about/products-platforms/',
  //     'https://dev-test.monstar-lab.com/bd/',
  //     'https://dev-test.monstar-lab.com/bd/contact/',
  //     'https://dev-test.monstar-lab.com/bd/about/',
  //     'https://dev-test.monstar-lab.com/bd/be-borderless/',
  //     'https://dev-test.monstar-lab.com/bd/projects/',
  //     'https://dev-test.monstar-lab.com/bd/cases/',
  //     'https://dev-test.monstar-lab.com/bd/services/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/nullam-a-nisl-est-et-auctor-urna-vestibulum-nisi-velit-4/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/monstar-lab-announces-jpy-700-million-us6-3-million-fundraise-to-fuel-its-global-expansion-3/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/sed-non-libero-id-purus-tincidunt-lobortis-id-egestas-est-vestibulum-orci-tellus-condimentum-vitae-2/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/nullam-a-nisl-est-et-auctor-urna-vestibulum-nisi-velit-2/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/sed-non-libero-id-purus-tincidunt-lobortis-id-egestas-est-vestibulum-orci-tellus-condimentum-vitae/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/global-web-released/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/aliquam-scelerisque-enim-eu-justo-congue-vel-feugiat-lacus-faucibus-in-mollis-purus-ut-nibh-pellentesque/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/global-sourcing-firm-monstar-lab-hires-new-general-manager-in-denmark/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/nullam-a-nisl-est-et-auctor-urna-vestibulum-nisi-velit/',
  //     'https://dev-test.monstar-lab.com/bd/ml-news/monstarlab-expands-business-to-europe-through-acquisition-of-nodes/',
  // );
  // $homeURL = 'https://dev-test.monstar-lab.com/bd/';
  $allUrls = [];
  $homeURL = home_url();
  $post_types = get_option( 'static_post_types', '' );
  $postTypes = explode(',', $post_types);
  $posts = get_posts([
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'post_type' => $postTypes,
      ]);
  foreach($posts as $key => $post){
   array_push($allUrls , get_permalink($post) );
  }
  $terms = get_terms('ml-expertinsights-category', ['hide_empty' => true]);
  foreach($terms as $key => $value){
    array_push($allUrls , get_category_link($value) );
  }
  // foreach( $allUrls as $key => $mainURL){
  //   $html = file_get_contents( $mainURL);
  //   if($mainURL === $homeURL){
  //     $thisPath = $filestructures['root'] . 'dist/';
  //   }else{
  //     /* Firstly make the folder to write a file */
  //     $url = substr_replace(substr(parse_url($mainURL)['path'], 1), "", -1) ;
  //     $subURL = str_replace($homeURL,"", $url);
  //     $subURL = str_replace($subFolderName . "/","", $url);
  //     $paths = explode('/', $subURL);
  //     $thisPath = $filestructures['root'] . 'dist/';
  //     foreach($paths as $key => $path ){
        
  //       $filename = $thisPath . $path . '/';
  //       if (!file_exists($filename)) {
  //         mkdir( $thisPath .  $path, 0777);
  //         echo "The directory ". $path . " was successfully created.<br>";
      
  //       } else {
  //         echo "The directory ". $path . " exists.<br>";
  //       }
  //       $thisPath = $thisPath . $path . '/';
  //     }
  //     /* Now grab the content from url */
  //   }
  //   $pattern = '/(<a\s[^>]*href\s*=\s*([\"\']?))(?:https:\/\/dev\-test.monstar\-lab.com\/bd)([^\" >]*?)/Ui';
  //   $html = preg_replace($pattern, '${1}http://cache-bd.localhost${3}', $html);
  //   /* Now write html in file */
  //   $myfile = fopen($thisPath . "index.html", "w") or die("Unable to open file!");
  //   fwrite($myfile, $html);
  //   fclose($myfile);
  // }
?>

<div class="wrap">
  <h1 class="wp-heading-inline">Build Static Site</h1>
  <br><br>
  <hr class="wp-header-end">

  <div class="form">
  <div class="progress-report">
  <ul></ul>
  </div>
    <form action="#" id="server_static_builder" name="server_static_builder" method="post">
      <input type="hidden" name="allurl" id="allurl" value='<?= json_encode($allUrls);?>'>
      <input type="text" name="localfolder" id="localfolder" value='<?= get_option('localfolder',  'dist' );?>'>
      <input type="hidden" name="homeurl" id="homeurl" value="<?= $homeURL;?>">
      <input type="hidden" name="subfoldername" id="subfoldername" value="<?= $subFolderName;?>">
      <input type="text" name="post_types" id="post_types" value="<?= $post_types; ?>" size="150">
      <input type="submit" value="Build" name="submit" style="position: fixed; bottom: 50px; right: 2%;">
    </form>

  </div>
</div>
