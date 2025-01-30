import { afterNextRender, Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class BriefService {
  
  public idiomaActual:string = "EN";
  public idiomaActualReves:string = "ES";
  public textos:any = [];
  public home:any = [
    {
      nav:{
        menu:[
          {
            title:"home",url:"/",type:"url",id:'home',offset:15
          },
          {
            title:"About us",url:"/about-us",type:"scroll",id:'aboutUs',offset:155
          },
          {
            title:"Our Services",url:"/our-services",type:"scroll",id:'ourServices',offset:40
          },
          {
            title:"Resources",url:"/resources",type:"scroll",id:'resources',offset:17
          },
          {
            title:"Contact",url:"/contact",type:"scroll",id:'contacto',offset:144
          }
        ],
        menusection:[
          {
            title:"home",url:"/",type:"url",id:'home',offset:15
          },
          {
            title:"About us",url:"/about-us",type:"url",id:'aboutUs',offset:155
          },
          {
            title:"Our Services",url:"/our-services/03/evaluation-and-modeling-of-agricultural-ecosystems",type:"url",id:'ourServices',offset:40
          },
          {
            title:"Resources",url:"/resources",type:"url",id:'resources',offset:17
          },
          {
            title:"Contact",url:"/contact",type:"scroll",id:'contacto',offset:144
          }
        ]
      },
      slider:{
        titulo: 'We work on Profitable Solutions for Truly Sustainable Agriculture',
        subtitulo:'We integrate the best of science, the most advanced technology, and the experience of farmers to enhance the benefits of truly sustainable agriculture.',
        boton:'About Us',
        sliders:[
          {
            img:'assets/img/home/slider/header_carrousel1.jpg',
            txt:'Sustainability',
            number:'01.',
            mobile:'assets/img/home/slider/header_carrousel_mobile_1.jpg'
          },
          {
            img:'assets/img/home/slider/header_carrousel2.jpg',
            txt:'Efficiency',
            number:'02.',
            mobile:'assets/img/home/slider/header_carrousel_mobile_2.jpg'
          },
          {
            img:'assets/img/home/slider/header_carrousel3.jpg',
            txt:'Transparency',
            number:'03.',
            mobile:'assets/img/home/slider/header_carrousel_mobile_3.jpg'
          },
          {
            img:'assets/img/home/slider/header_carrousel4.jpg',
            txt:'Compromise',
            number:'04.',
            mobile:'assets/img/home/slider/header_carrousel_mobile_4.jpg'
          }
        ]
      },
      ourservice:{
        titulo:'Our Services',
        subtitulo:'We are committed to maximizing the economic value of sustainable agriculture, ensuring a world with better food and less climate impact.',
        itemstext:'Our expertise ensures',
        otherservices:'Other services',
        servicios:[
          {
            txt:'EVALUATION AND MODELING OF AGRICULTURAL ECOSYSTEMS',
          },
          {
            txt:'CARBON AND GREENHOUSE GAS MANAGEMENT ANALYSIS',
          },
          {
            txt:'SUPPORT FOR VERIFICATION AND CERTIFICATION OF EMISSION CONTROL AND REDUCTION LEVELS THROUGH MDL TOOLS',
          }
        
        ]
      },
      alianzas:{
        titulo:'Partnerships',
        subtitulo:'The urgency of adopting sustainable agriculture practices has intensified in light of the United Nations\' forecast that global agricultural production will need to increase by 70% by 2050 to feed an estimated population of 9.6 billion people. This increase is necessary not only to manage demographic growth but also to address the adverse effects of climate change that are already challenging global agricultural systems.<br/><br/>The World Resources Institute report, supported by the UN and the World Bank, emphasizes the need to implement climate-smart agriculture practices. These practices include improving agricultural and livestock productivity in ways that preserve the environment and reduce greenhouse gas emissions. They aim not only to close the gap between food demand and supply but also to promote climate resilience and sustainability, ensuring that agricultural methods support both food security and environmental protection.<br/><br/>In this context, Byontek works as a change agent within the global community, collaborating with organizations like Aapresid to promote and implement these sustainable practices. Byontek\'s collaboration with centers of excellence and advanced technological platforms is crucial for driving innovations that enable more sustainable and efficient agriculture. These actions are crucial for addressing current and future challenges, ensuring a balanced and effective approach to food production.',
      },
      nosotros:{
        titulo:'About Us',
        titulobr:'About Us',
        titular:'Our Commitment to the Future: We Unite Science and Technology to Revolutionize Sustainable Agriculture',
        textohome:'At Byontek, we firmly believe that farmers can significantly benefit from improvements in productivity, cost reduction, and increased resilience of their operations. This not only benefits farmers individually but also contributes to a virtuous cycle towards a more sustainable planet for everyone. We employ advanced technologies to deepen our understanding of agricultural systems, thereby helping to mitigate climate change, strengthen food system resilience, and improve outcomes for producers.',
        textoseccion:'At Byontek, we firmly believe that producers can greatly benefit from improvements in productivity, cost reduction, and sustainable strategies. This not only benefits farmers but also contributes to a virtuous cycle towards a more sustainable planet. We employ advanced technologies to deepen our understanding of agricultural systems, helping to mitigate climate change, strengthen food system resilience, and improve outcomes for producers.<br/><br/>As a startup in the AgTech sector, Byontek is committed to converting environmental assets into financial assets through a scientific and technological approach. We recognize the importance of integrating transdisciplinary technologies, scientific knowledge, and producer expertise, facilitating access to financial markets through innovative economic models.<br/><br/>We facilitate access to international certifications and the carbon credits market through scientifically validated processes, transforming environmental assets into financial ones, promoting sustainable practices, and supporting new research and technological development programs.',
        boton:'Know more'
      },
      recursos:{
        titulo:'Resources',
        subtitulo:'Discover the Latest News With Us:',
        tituloSeccion:'Other articles you may be interested in:',
        boton:'See More',
        filter:'Filters',
        todos: 'ALL',
        boton2:'Read more'
      },
      footer:{
        titulo:'We drive Sustainable Agriculture by combining cutting-edge Science, Innovative Technology, and Producers\' Experience to maximize benefits and protect our planet.',
        subtitulo:'Contact Us!',
        telefono:'Phone',
        direccion:'Adress',
      },
      mision:{
        titulo:'Our Mission',
        texto:'Our mission is to drive sustainability and enhance agricultural profitability by integrating advanced science, innovative technology, and the latest developments in remote sensing, crop modeling, and artificial intelligence. We are committed to helping our clients achieve their sustainability goals, optimizing production, and addressing the challenges of a world that demands more high-quality food produced sustainably.<br/><br/>We develop technological solutions and innovative tools designed to deepen the understanding of agricultural systems, facilitating the implementation of best agricultural practices. Our focus is on maintaining food system resilience and improving economic outcomes for producers in diverse environments and scenarios.<br/><br/>We dedicate ongoing efforts to reduce greenhouse gas emissions through the application of advanced technology and scientific knowledge. We validate and add value to best agricultural practices for commercial crops. Our goal is to lead the transformation towards a more sustainable and economically viable agriculture, benefiting both agricultural producers and the planet.',
      },
      vision:{
        titulo:'Our Vision',
        texto:'At Byontek, we aspire to lead the transformation of agriculture through the integration of advanced technology, deep scientific knowledge, and innovative financial approaches. We believe that collaboration among international research communities, professional networks, and producers committed to sustainable practices is essential for developing an agricultural model that not only meets current needs but also addresses deficiencies in existing systems and contributes to mitigating climate change.<br/><br/>We envision a future where regenerative and sustainable agriculture improves soil health, increases crop productivity, and strengthens our communities\' resilience to climate challenges. Our goal is to empower the next generation of farmers with tools and knowledge that enable them to meet the world\'s growing demand for food responsibly and sustainably.<br/><br/>We are committed to continuous innovation, using advanced technological platforms to expand farmer-centric initiatives. We facilitate access to carbon credit markets and support agricultural businesses in their efforts to achieve sustainability goals and climate commitments.<br/><br/>At Byontek, we not only envision a better world, but we also work tirelessly to make it a reality.',
      },
      serviciossection:{
        carbon:{
          number:'01',
          title:'Carbon Management and Greenhouse Gas Analysis',
          text:'At Byontek, we measure and manage carbon emissions and the carbon intensity of crops, from individual fields to specific regions. We use advanced models to assess the impact of regenerative agricultural practices on atmospheric carbon, providing a comprehensive view of environmental impact.<br/><br/>We continuously monitor farmers\' progress in implementing new practices, offering critical data for constant adjustments. Our advanced technology enables real-time carbon emission modeling, facilitating precise measurements of regenerative practices and carbon reduction advancements.<br/><br/>We use Life Cycle Analysis (LCA) to evaluate the environmental impact of agricultural products, from production to consumption. We quantify greenhouse gas emissions, energy consumption, and water usage, providing a complete view of environmental impact.<br/><br/>Our approach is reinforced with predictive models based on artificial intelligence, simulating management scenarios and their effects on carbon emission reduction, helping farmers make more informed and sustainable decisions.At BYONTEK, accurate greenhouse gas footprint accounting in agriculture and livestock marks the beginning of our management of sustainable practices, transforming these methods into tangible benefits. We work closely with scientists and farmers to establish and accurately measure carbon footprints at various scales.',
          items:[]
        },
        optimization:{
          number:'02',
          title:'Optimization and Certification of Agricultural Practices to Monetize Sustainability',
          text:'At Byontek, we facilitate access to financial incentives for farmers implementing regenerative agriculture practices. We develop projects based on science and smart technology to quantify and certify emission reductions and carbon sequestration, generating verifiable carbon credits. These credits can be traded in voluntary and regulated markets.<br/><br/>We collaborate with experts and farmers to apply advanced technologies that facilitate the certification of emission reductions. We use real-time geographic modeling to assess the large-scale adoption of regenerative practices, enhancing progress measurement and necessary adjustments.<br/><br/>We work with innovative financial tools that support the transition to regenerative agriculture, mitigating risks and costs. We collaborate with private entities to create self-sustaining incentive programs that provide farmers with the necessary means to implement sustainable and profitable practices.<br/><br/>These programs improve soil health, increase biodiversity, and provide direct economic benefits to farmers, supporting the expansion of activities that mitigate climate change and promote sustainable agriculture.',
          items:[
            {
              title:'Commitment to Certification and Emission Reduction',
              text:'En Byontek, estamos capacitados para facilitar la certificación de nuestros proyectos conforme a los más altos estándares internacionales, asegurando que nuestras metodologías cumplen con los criterios de calidad y precisión necesarios para validar la reducción de emisiones de carbono. Nuestro enfoque permite a los agricultores y organizaciones cuantificar, reportar y reducir sus emisiones de carbono de manera efectiva, proporcionando una evaluación exhaustiva del ciclo de vida de las prácticas agrícolas.<br/><br/>En Byontek trabajamos para mejorar la sostenibilidad de las prácticas agricolas sustentables y facilitar a los productores nuevas oportunidades de monetización en el mercado de carbono, contribuyendo significativamente a la lucha contra el cambio climático. Nuestra plataforma avanzada ofrece soluciones personalizadas que ayudan a alcanzar los objetivos de sostenibilidad de manera transparente y verificable, alineándose con las mejores prácticas de la industria para la gestión de emisiones de carbono.'
            }
          ]
        },
        evaluation:{
          number:'03',
          title:'Assessment and Modeling of Agricultural Ecosystems',
          text:'At Byontek, we use advanced science and technology to optimize agricultural sustainability. With satellite imagery, drones, and machine learning, we analyze and model management practices to simulate scenarios and improve decision-making.<br/><br/>We assess soil and crop quality, optimizing fertilizers and agrochemicals. We promote biotechnological systems for pest control and seed development, creating geospatial data warehouses for real-time analysis.<br/><br/>We integrate biotechnology and advanced data analysis to conserve soil, protect biodiversity, and reduce greenhouse gas emissions, fostering sustainable and resilient agriculture.',
          items:[
            {
              title:'Crop Simulation with Multi-Model Approach',
              text:'At Byontek, we use advanced models to predict crop growth and yield, considering soil, climate, genetics, and agricultural management. Our multi-model approach simulates agricultural conditions and long-term management strategies.<br/><br/>We assess crops, soil, water, and nutrients, adapting rotations, planting dates, density, and applications of irrigation and fertilizers. We compare multiple management strategies simultaneously to evaluate their long-term impact.<br/><br/>We provide farmers with precise tools for informed decision-making, understanding climate risks. Our approach offers critical data on smart and sustainable practices.<br/><br/>Our simulation technology enhances productivity, reduces carbon footprint, and promotes regenerative agricultural practices. By predicting and adapting management strategies, we help farmers conserve soil, protect biodiversity, and reduce emissions, fostering sustainable and resilient agriculture.'
            }
          ]
        }
      },
      Brief:{
        titulo:'A Brief History Over Time',
        subtitulo:'Sustainability, Climate Change, Regenerative Agriculture, and Us...'
      },
      recursossection:[
        {
          title:"1980",
          img:["assets/img/about-us/rodale-institute.jpg"],
          text:"The Rodale Institute begins using the term \"regenerative agriculture\" and establishes the Regenerative Agriculture Association (USA).",
          id:1,
          lado:'left'
        },
        {
          title:"1988",
          img:["assets/img/about-us/ipcc.jpg"],
          text:"The Intergovernmental Panel on Climate Change (IPCC) was established in 1988 to facilitate comprehensive assessments of scientific, technical, and socioeconomic knowledge about climate change, its causes, potential impacts, and response strategies.",
          id:2,
          lado:'left'
        },
        {
          title:"1989",
          img:["assets/img/about-us/aapresid-copia.jpg"],
          text:"The Argentine Association of No-Till Producers (Aapresid) is founded to promote sustainable agriculture based on the rational and intelligent use of natural resources through access to knowledge and technological innovation.",
          id:3,
          lado:'left'
        },
        {
          title:"1992",
          img:["assets/img/about-us/brief/cumbre-tierra.jpg"],
          text:"United Nations Conference on Environment and Development (\"Earth Summit\"), held in Rio de Janeiro.",
          id:4,
          lado:'left'
        },
        {
          title:"1996",
          img:["assets/img/about-us/brief/webp/Imagen1.webp"],
          text:"Training in the USA (EOSAT) on remote sensing using Thematic Mapper and Multispectral Scanner tools (Landsat 5) and Geographic Information Systems (ESRI) applied to the environment.",
          id:4,
          lado:'right'
        },
        {
          title:"1998",
          img:["assets/img/about-us/brief/webp/Imagen4.webp","assets/img/about-us/brief/webp/Imagen5.webp","assets/img/about-us/brief/webp/Imagen6.webp"],
          text:"Conferences and training sessions at national and international events on climate change, environment, and applied technology.",
          id:5,
          lado:'right'
        },
        {
          title:"1999",
          img:["assets/img/about-us/brief/webp/Imagen2.webp","assets/img/about-us/brief/webp/Imagen3.webp","assets/img/about-us/brief/webp/1bis.webp"],
          text:"Environmental and climate risk studies in industrial and oil operations in Argentina based on remote sensing and applied science.",
          id:5,
          lado:'right'
        },
        {
          title:"2005",
          img:["assets/img/about-us/cmnu.jpg"],
          text:"The Kyoto Protocol, adopted on December 11, 1997, but entering into force on February 16, 2005, after a complex ratification process, operationalized the United Nations Framework Convention on Climate Change. It committed industrialized countries to limit and reduce greenhouse gas emissions (GHGs) according to agreed individual targets.",
          id:6,
          lado:'left'
        },
        {
          title:"2006",
          img:["assets/img/about-us/brief/webp/Imagen7.webp","assets/img/about-us/brief/webp/IMagen8.webp","assets/img/about-us/brief/webp/Imagen9.webp"],
          text:"First studies on environmental risk and climate impact in the Amazon.",
          id:6,
          lado:'right'
        },
        {
          title:"2008",
          img:["assets/img/about-us/brief/webp/Imagen10.webp"],
          text:"Studies using remote sensing to assess erosion and environmental degradation in the Andes Mountain Range.",
          id:7,
          lado:'right'
        },
        {
          title:"2013",
          img:["assets/img/about-us/brief/webp/Imagen11.jpg","assets/img/about-us/brief/webp/Imagen12.webp"],
          text:"Environmental risk studies at a large scale in the Amazon and pioneering use of drones in South America for environmental studies in a large-scale project.",
          id:8,
          lado:'right'
        },
        {
          title:"2015",
          img:["assets/img/about-us/paris-2015.jpg"],
          text:"COP 21 and the Paris Agreement. The Agreement includes commitments from all countries to reduce their emissions and collaborate to adapt to the impacts of climate change, along with calls for countries to increase their commitments over time.",
          id:9,
          lado:'left'
        },
        {
          title:"2018",
          img:["assets/img/about-us/brief/webp/Imagen13.jpg","assets/img/about-us/brief/webp/Imagen14.jpg","assets/img/about-us/brief/webp/Imagen15.jpg"],
          text:"Various studies using remote sensing for monitoring cultivated land expansion, erosion, water availability, and climate impact.",
          id:10,
          lado:'right'
        },
        {
          title:"2022",
          img:["assets/img/about-us/fewsus.jpg"],
          text:"First FEWSUS Symposium in the Southern Cone (Argentina) \"Circular Bioeconomy Systems for Urban-Rural Co-prosperity\"",
          id:11,
          lado:'left'
        },
        {
          title:"2022",
          img:["assets/img/about-us/brief/webp/imagen17.webp","assets/img/about-us/brief/webp/Imagen18.webp","assets/img/about-us/brief/webp/Imagen19.webp"],
          text:"Active participation in the Organizing Committee of the 2022 FEWSUS Annual Symposium.",
          id:12,
          lado:'right'
        },
        {
          title:"2023",
          img:["assets/img/about-us/2023-logo.jpg"],
          text:"BYONTEK Foundation",
          id:13,
          lado:'right'
        },
        {
          title:"2023",
          img:["assets/img/about-us/carbon-forum.jpg"],
          text:"First ARGENTINA CARBON FORUM aimed at promoting the carbon market, bringing stakeholders together, and evaluating the strategy and guidelines that the public sector is working on regarding carbon markets.",
          id:14,
          lado:'left'
        },
        {
          title:"2023",
          img:["assets/img/about-us/brief/webp/Imagen20.jpg"],
          text:"Active participation in the first edition of the Argentina Carbon Forum.",
          id:15,
          lado:'right'
        },
        {
          title:"2023",
          img:["assets/img/about-us/aapresid2.webp"],
          text:"31st Aapresid Congress \"C, Element of Life.\"",
          id:15,
          lado:'left'
        },
        {
          title:"2023",
          img:["assets/img/about-us/foto4.webp"],
          text:"We actively participated in the 31st Aapresid Congress, featuring Dr. Bruno Basso from Michigan State University (MSU, USA) and researchers from the University of Tennessee (UTK, USA) as speakers on various topics.",
          id:16,
          lado:'right'
        }
      ],
      Contacto:{
        titulo:'Contact',
        p1:'Byontek is committed to protecting and respecting your privacy, and we\'ll only use your personal information to administer your account and to provide the products and services you requested from us.',
        p2:'From time to time, we would like to contact you about our products and services, as well as other content that may be of interest to you. If you consent to us contacting you for this purpose, please tick below to say how you would like us to contact you:',
        p3:'You can unsubscribe from these communications at any time.',
        p4:'By clicking submit below, you consent to allow Byontek to store and process the personal information submitted above to provide you the content requested.',
        acuerdo:'I agree to receive other communications from Byontek.',
        nombre:'Frist Name',
        apellido: 'Last name',
        email:'Email',
        celular:'Phone number',
        company: 'Company name',
        puesto: 'Job title',
        industria:'Industry',
        mensaje: 'Message',
        boton:'Send message',
        errores:'Is required',
        placeholder:'Enter Your ',
        corto:'Too small to be valid',
        emailerror:'Not seems to be an email...',
        emailmandado:'Email sent successfully!<br/>We will contact you shortly...',
        emailnomandado:'We had a problem while sending email...',
        opciones:[
          "Agricultural Inputs",
          "Agricultural Retailer",
          "Banking Institution",
          "Carbon Advisors / Program Developers",
          "Consumer / Food",
          "Co-Ops / Agronomists",
          "Ethanol / Biofuels",
          "Insurance Provider",
          "Land Investment / REIT",
          "Meat / Dairy / Feed / Ingredients",
          "Public Sector",
          "Other"
        ]

      }
    }
  ]; 


  public inicio:any = [
    {
      nav:{
        menu:[
          {
            title:"inicio",url:"/",type:"url",id:'home',offset:15
          },
          {
            title:"Sobre Nosotros",url:"/sobre-nosotros",type:"scroll",id:'aboutUs',offset:155
          },
          {
            title:"Nuestros Servicios",url:"/nuestros-servicios",type:"scroll",id:'ourServices',offset:40
          },
          {
            title:"Recursos",url:"/recursos",type:"scroll",id:'resources',offset:17
          },
          {
            title:"Contacto",url:"/contacto",type:"scroll",id:'contacto',offset:144
          }
        ],
        menusection:[
          {
            title:"inicio",url:"/",type:"url",id:'home',offset:15
          },
          {
            title:"Sobre Nosotros",url:"/sobre-nosotros",type:"url",id:'aboutUs',offset:155
          },
          {
            title:"Nuestros Servicios",url:"/nuestros-servicios/03/evaluacion-y-modelizacion-de-ecosistemas-agricolas",type:"url",id:'ourServices',offset:40
          },
          {
            title:"Recursos",url:"/recursos",type:"url",id:'resources',offset:17
          },
          
          {
            title:"Contacto",url:"/contacto",type:"scroll",id:'contacto',offset:17
          }
        ]
      },
      slider:{
        titulo: 'Trabajamos en Soluciones Rentables para una Verdadera Agricultura Sostenible',
        subtitulo:'Integramos lo mejor de la ciencia, la tecnología más avanzada y la experiencia de los agricultores para potenciar los beneficios de una agricultura verdaderamente sostenible.',
        boton:'Sobre Nosotros',
        sliders:[
          {
            img:'assets/img/home/slider/header_carrousel1.jpg',
            txt:'Sustentabilidad',
            number:'01.',
            mobile:'assets/img/home/slider/header_carrousel_mobile_1.jpg'
          },
          {
            img:'assets/img/home/slider/header_carrousel2.jpg',
            txt:'Eficiencia',
            number:'02.',
            mobile:'assets/img/home/slider/header_carrousel_mobile_2.jpg'
          },
          {
            img:'assets/img/home/slider/header_carrousel3.jpg',
            txt:'Transparencia',
            number:'03.',
            mobile:'assets/img/home/slider/header_carrousel_mobile_3.jpg'
          },
          {
            img:'assets/img/home/slider/header_carrousel4.jpg',
            txt:'Compromiso',
            number:'04.',
            mobile:'assets/img/home/slider/header_carrousel_mobile_4.jpg'
          }
        ]
      },
      ourservice:{
        titulo:'Nuestros Servicios',
        subtitulo:'Estamos comprometidos a maximizar el valor económico de la agricultura sostenible, garantizando un mundo con mejores alimentos y menor impacto climático.',
        itemstext:'Nuestra experiencia garantiza',
        otherservices:'Otros servicios',
        servicios:[
          {
            txt:'EVALUACIÓN Y MODELIZACIÓN DE ECOSISTEMAS AGRÍCOLAS',
          },
          {
            txt:'ANÁLISIS DE GESTIÓN DEL CARBONO Y GASES DE EFECTO INVERNADERO',
          },
          {
            txt:'CERTIFICACIÓN Y OPTIMIZACIÓN DE PRÁCTICAS AGRÍCOLAS PARA MONETIZAR CARBONO',
          }
        
        ]
      },
      alianzas:{
        titulo:'Alianzas',
        subtitulo:'La urgencia de adoptar prácticas de agricultura sostenible se ha intensificado ante la previsión de las Naciones Unidas de que para el año 2050 la producción agrícola mundial deberá incrementarse en un 70% para alimentar a una población que se estima alcanzará los 9.6 mil millones de personas. Este incremento es necesario para manejar no solo el crecimiento demográfico, sino también los efectos adversos del cambio climático que ya están poniendo a prueba los sistemas agrícolas globales.<br/><br/>El informe del World Resources Institute, apoyado por la ONU y el Banco Mundial, destaca la necesidad de implementar agricultura inteligente respecto al clima que incluye mejorar la productividad agrícola y ganadera de manera que se preserve el medio ambiente y se reduzcan las emisiones de gases de efecto invernadero. Estas prácticas no solo buscan cerrar la brecha entre la demanda y la oferta de alimentos, sino que también promueven la resiliencia climática y la sostenibilidad, asegurando que los métodos agrícolas apoyen tanto la seguridad alimentaria como la protección ambiental.<br/><br/>En este contexto, Byontek trabaja como un agente de cambio dentro de la comunidad global, trabajando junto a organizaciones como Aapresid para promover y aplicar estas prácticas sostenibles. La colaboración de Byontek con centros de excelencia y plataformas tecnológicas avanzadas es fundamental para impulsar innovaciones que permitan una agricultura más sostenible y eficiente. Estas acciones son cruciales para enfrentar los desafíos actuales y futuros, asegurando un enfoque equilibrado y efectivo en la producción de alimentos.',
      },
      nosotros:{
        titulo:'Sobre Nosotros',
        titulobr:'Sobre Nosotros',
        titular:'Nuestro Compromiso con el Futuro: Unimos Ciencia y Técnología para Revolucionar la Agricultura Sostenible',
        textohome:'En Byontek, creemos firmemente que los agricultores pueden beneficiarse significativamente a través de mejoras en la productividad, reducción de costos y aumento de la resiliencia de sus explotaciones. Esto no solo beneficia a los agricultores individualmente, sino que contribuye a un ciclo virtuoso hacia un planeta más sostenible para todos. Utilizamos tecnologías avanzadas para profundizar nuestro entendimiento de los sistemas agrícolas, ayudando así a mitigar el cambio climático, a fortalecer la resiliencia del sistema alimentario y a mejorar los resultados para los productores.',
        textoseccion:'En Byontek, estamos convencidos de que los productores pueden beneficiarse enormemente mediante mejoras en la productividad, reducción de costos y estrategias sustentables. Esto no solo beneficia a los agricultores, sino que contribuye a un ciclo virtuoso hacia un planeta más sostenible. Utilizamos tecnologías avanzadas para profundizar en el entendimiento de los sistemas agrícolas, ayudando a mitigar el cambio climático, fortalecer la resiliencia del sistema alimentario y mejorar los resultados para los productores.<br/><br/>Como una startup en el ámbito de AgTech, Byontek está comprometida con la conversión de activos ambientales en activos financieros mediante un enfoque científico-tecnológico. Reconocemos la importancia de integrar tecnologías transdisciplinarias, conocimientos científicos y la experiencia del productor, facilitando el acceso a los mercados financieros a través de modelos económicos innovadores.<br/><br/>Facilitamos el acceso a certificaciones internacionales y al mercado de créditos de carbono mediante procesos científicamente validados, transformando activos ambientales en financieros, fomentando prácticas sustentables y apoyando nuevos programas de investigación y desarrollo tecnológico.',
        boton:'Ver más',
      },
      recursos:{
        titulo:'Recursos',
        subtitulo:'Descubre las últimas noticias con nosotros:',
        tituloSeccion:'Otros artículos que te pueden interesar:',
        boton:'Ver más',
        filter:'Filtros',
        todos: 'TODOS',
        boton2:'Leer más'
      },
      footer:{
        titulo:'Impulsamos la Agricultura Sostenible Uniendo Ciencia de Vanguardia, Tecnología Innovadora y la Experiencia de los Productores, para Maximizar los Beneficios y Proteger Nuestro Planeta.',
        subtitulo:'Contactanos!',
        telefono:'Teléfono',
        direccion:'Dirección',
      },
      mision:{
        titulo:'Nuestra Misión',
        texto:'Nuestra misión es impulsar la sostenibilidad y mejorar la rentabilidad agrícola mediante la integración de ciencia avanzada, tecnología innovadora y los últimos desarrollos en sensores remotos, modelos de cultivos e inteligencia artificial. Nos comprometemos a ayudar a nuestros clientes a alcanzar sus metas de sostenibilidad, optimizando la producción y enfrentando los desafíos de un mundo que demanda más alimentos de mayor calidad y producidos de manera sustentable.<br/><br/>Desarrollamos soluciones tecnológicas y herramientas innovadoras diseñadas para profundizar el entendimiento de los sistemas agrícolas, facilitando la implementación de las mejores prácticas agrícolas. Nuestro enfoque se centra en mantener la resiliencia del sistema alimentario y mejorar los resultados económicos de los productores en entornos diversos y ante diferentes escenarios.<br/><br/>Dedicamos esfuerzos continuos a reducir las emisiones de gases de efecto invernadero mediante la aplicación de tecnología avanzada y conocimiento científico. Validamos y agregamos valor a las mejores prácticas agrícolas para obtener cultivos comerciales. Nuestro objetivo es liderar la transformación hacia una agricultura más sostenible y económicamente viable, beneficiando tanto a los productores agrícolas como al planeta.',
      },
      vision:{
        titulo:'Nuestra Visión',
        texto:'En Byontek, aspiramos a liderar la transformación de la agricultura mediante la integración de tecnología avanzada, conocimiento científico profundo y enfoques financieros innovadores. Creemos que la colaboración entre comunidades de investigación internacionales, redes de profesionales y productores comprometidos con prácticas sostenibles es esencial para desarrollar un modelo agrícola que no solo responda a las necesidades actuales, sino que también aborde las deficiencias de los sistemas existentes y contribuya a mitigar el cambio climático.<br/><br/>Visualizamos un futuro donde la agricultura regenerativa y sostenible mejore la salud del suelo, aumente la productividad de los cultivos y fortalezca la resiliencia de nuestras comunidades frente a los desafíos climáticos. Nuestra meta es empoderar a la próxima generación de agricultores con herramientas y conocimientos que les permitan satisfacer la creciente demanda mundial de alimentos de manera responsable y sostenible.<br/><br/>Estamos comprometidos con la innovación continua, utilizando plataformas tecnológicas avanzadas para ampliar las iniciativas centradas en el agricultor. Facilitamos el acceso a mercados de créditos de carbono y apoyamos a las empresas agrícolas en sus esfuerzos por alcanzar objetivos de sostenibilidad y compromisos climáticos.<br/><br/>En Byontek, no solo imaginamos un mundo mejor, trabajamos incansablemente para hacerlo realidad.',
      },
      serviciossection:{
        carbon:{
          number:'01',
          title:'Análisis de Gestión del Carbono y Gases de Efecto Invernadero',
          text:'En Byontek, medimos y gestionamos las emisiones de carbono y la intensidad de carbono de los cultivos, desde campos individuales hasta regiones específicas. Utilizamos modelos avanzados para evaluar el impacto de prácticas agrícolas regenerativas sobre el carbono atmosférico, proporcionando una visión integral del impacto ambiental.<br/><br/>Monitoreamos continuamente el progreso de los agricultores en la implementación de nuevas prácticas, ofreciendo datos críticos para ajustes constantes. Nuestra tecnología avanzada permite modelar emisiones de carbono en tiempo real, facilitando mediciones precisas de prácticas regenerativas y avances en reducción de carbono.<br/><br/>Utilizamos Análisis de Ciclo de Vida (ACV) para evaluar el impacto ambiental de los productos agrícolas, desde la producción hasta el consumo. Cuantificamos emisiones de gases de efecto invernadero, consumo de energía y uso de agua, brindando una visión completa del impacto ambiental.<br/><br/>Nuestro enfoque se refuerza con modelos predictivos basados en inteligencia artificial, simulando escenarios de manejo y sus efectos en la reducción de emisiones de carbono, ayudando a los agricultores a tomar decisiones más informadas y sostenibles.',
          items:[]
        },
        optimization:{
          number:'02',
          title:'Optimización y Certificación de Prácticas Agrícolas para Monetizar la Sustentabilidad',
          text:'En Byontek, facilitamos el acceso a incentivos financieros para agricultores que implementan prácticas de agricultura regenerativa. Desarrollamos proyectos basados en ciencia y tecnología inteligente para cuantificar y certificar la reducción de emisiones y el secuestro de carbono, generando créditos de carbono verificables. Estos créditos pueden comercializarse en mercados voluntarios y regulados.<br/><br/>Colaboramos con expertos y agricultores para aplicar tecnologías avanzadas que facilitan la certificación de reducciones de emisiones. Utilizamos modelización geográfica en tiempo real para evaluar la adopción de prácticas regenerativas a gran escala, mejorando la medición de progresos y ajustes necesarios.<br/><br/>Trabajamos con herramientas financieras innovadoras que apoyan la transición a la agricultura regenerativa, mitigando riesgos y costos. Colaboramos con entidades privadas para crear programas de incentivos autosostenibles que proporcionen a los agricultores los medios necesarios para implementar prácticas sostenibles y rentables.<br/><br/>Estos programas mejoran la salud del suelo, aumentan la biodiversidad y proporcionan beneficios económicos directos a los agricultores, apoyando la expansión de actividades que mitigan el cambio climático y promueven una agricultura sostenible.',
          items:[
            {
              title:'Compromiso con la Certificación y la Reducción de Emisiones',
              text:'En Byontek, estamos capacitados para facilitar la certificación de nuestros proyectos conforme a los más altos estándares internacionales, asegurando que nuestras metodologías cumplen con los criterios de calidad y precisión necesarios para validar la reducción de emisiones de carbono. Nuestro enfoque permite a los agricultores y organizaciones cuantificar, reportar y reducir sus emisiones de carbono de manera efectiva, proporcionando una evaluación exhaustiva del ciclo de vida de las prácticas agrícolas.<br/><br/>En Byontek trabajamos para mejorar la sostenibilidad de las prácticas agricolas sustentables y facilitar a los productores nuevas oportunidades de monetización en el mercado de carbono, contribuyendo significativamente a la lucha contra el cambio climático. Nuestra plataforma avanzada ofrece soluciones personalizadas que ayudan a alcanzar los objetivos de sostenibilidad de manera transparente y verificable, alineándose con las mejores prácticas de la industria para la gestión de emisiones de carbono.'
            }
          ]
        },
        evaluation:{
          number:'03',
          title:'Evaluación y Modelización de Ecosistemas Agrícolas',
          text:'En Byontek, utilizamos ciencia y tecnología avanzada para optimizar la sostenibilidad agrícola. Con imágenes satelitales, drones y aprendizaje automático, analizamos y modelamos prácticas de gestión para simular escenarios y mejorar la toma de decisiones.<br/><br/>Evaluamos la calidad del suelo y los cultivos, optimizando fertilizantes y agroquímicos. Promovemos sistemas biotecnológicos para control de plagas y desarrollo de semillas, creando almacenes de datos geoespaciales para análisis en tiempo real.<br/><br/>Integramos biotecnología y análisis de datos avanzados para conservar el suelo, proteger la biodiversidad y reducir emisiones de gases de efecto invernadero, fomentando una agricultura sostenible y resiliente.',
          items:[
            {
              title:'Simulación de Cultivos con Enfoque Multi-Modelo',
              text:'En Byontek, utilizamos modelos avanzados para predecir el crecimiento y rendimiento de cultivos, considerando suelo, clima, genética y gestión agrícola. Nuestro enfoque multi-modelo simula condiciones agrícolas y estrategias de manejo a largo plazo.<br/><br/>Evaluamos cultivos, suelo, agua y nutrientes, adaptando rotaciones, fechas de siembra, densidad y aplicaciones de riego y fertilizantes. Comparamos múltiples estrategias de manejo simultáneamente para evaluar su impacto a largo plazo.<br/><br/> Proporcionamos a los agricultores herramientas precisas para decisiones informadas, comprendiendo riesgos climáticos. Nuestro enfoque ofrece datos críticos sobre prácticas inteligentes y sostenibles.<br/><br/>Nuestra tecnología de simulación mejora la productividad, reduce la huella de carbono y promueve prácticas agrícolas regenerativas. Al predecir y adaptar estrategias de manejo, ayudamos a los agricultores a conservar el suelo, proteger la biodiversidad y reducir emisiones, fomentando una agricultura sostenible y resiliente.'
            }
          ]
        }
      },
      Brief:{
        titulo:'Una Breve Historia<br/>en el Tiempo',
        subtitulo:'la sustentabilidad, el cambio climático, la agricultura regenerativa y nosotros...'
      },
      recursossection:[
        {
          title:"1980",
          img:["assets/img/about-us/rodale-institute.jpg"],
          text:"El Instituto Rodale comienza a utilizar el término “agricultura regenerativa” y crea la Asociación de Agricultura Regenerativa (USA).",
          id:1,
          lado:'left'
        },
        {
          title:"1988",
          img:["assets/img/about-us/ipcc.jpg"],
          text:"Grupo Intergubernamental de Expertos sobre el Cambio Climático (IPCC) creado en 1988 para facilitar evaluaciones integrales del estado de los conocimientos científicos, técnicos y socioeconómicos sobre el cambio climático, sus causas, posibles repercusiones y estrategias de respuesta.",
          id:2,
          lado:'left'
        },
        {
          title:"1989",
          img:["assets/img/about-us/aapresid-copia.jpg"],
          text:"Se funda la Asociación Argentina de Productores en Siembra Directa (Aapresid) para difundir una agricultura sustentable, basada en el uso racional e inteligente de los recursos naturales a través del acceso al conocimiento y la innovación tecnológica.",
          id:3,
          lado:'left'
        },
        {
          title:"1992",
          img:["assets/img/about-us/brief/cumbre-tierra.jpg"],
          text:"Conferencia de la ONU sobre Medio Ambiente y Desarrollo (“Cumbre de la Tierra”, Río de Janeiro).",
          id:3,
          lado:'left'
        },
        {
          title:"1996",
          img:["assets/img/about-us/brief/webp/Imagen1.webp"],
          text:"Capacitación en los EEUU (EOSAT) en sensores remotos y herramientas Thematic Mapper y Multispectral Scanner (Landsat 5) y en Sistemas de Información Geografica  (ESRI) aplicados al ambiente.",
          id:3,
          lado:'right'
        },
        {
          title:"1998",
          img:["assets/img/about-us/brief/webp/Imagen4.webp","assets/img/about-us/brief/webp/Imagen5.webp","assets/img/about-us/brief/webp/Imagen6.webp"],
          text:"Conferencias y capacitaciones en eventos Nacionales e Internacionales en cambio climático, medio ambiente y tecnología aplicada.",
          id:4,
          lado:'right'
        },
        {
          title:"1999",
          img:["assets/img/about-us/brief/webp/Imagen2.webp","assets/img/about-us/brief/webp/Imagen3.webp","assets/img/about-us/brief/webp/1bis.webp"],
          text:"Estudios de Riesgo ambiental y climático en operaciones industriales y petroleras en Argentina basados en sensores remotos y ciencia aplicada.",
          id:5,
          lado:'right'
        },
        {
          title:"2005",
          img:["assets/img/about-us/cmnu.jpg"],
          text:"Protocolo de Kyoto , aprobado el 11 de diciembre de 1997, pero debido a un complejo proceso de ratificación, entró en vigor el 16 de febrero de 2005. Puso en funcionamiento la Convención Marco de las Naciones Unidas sobre el Cambio Climático, comprometiendo a los países industrializados a limitar y reducir las emisiones de gases de efecto invernadero (GEI) de conformidad con las metas individuales acordadas.",
          id:6,
          lado:'left'
        },
        {
          title:"2006",
          img:["assets/img/about-us/brief/webp/Imagen7.webp","assets/img/about-us/brief/webp/IMagen8.webp","assets/img/about-us/brief/webp/Imagen9.webp"],
          text:"Primeros estudios de riesgo ambiental e impacto climático en el Amazonas.",
          id:6,
          lado:'right'
        },
        {
          title:"2008",
          img:["assets/img/about-us/brief/webp/Imagen10.webp"],
          text:"Estudios mediante sensores remotos de erosión y deterioro ambiental en la Cordillera de Los Andes.",
          id:7,
          lado:'right'

        },
        {
          title:"2013",
          img:["assets/img/about-us/brief/webp/Imagen11.jpg","assets/img/about-us/brief/webp/Imagen12.webp"],
          text:"Estudios de Riesgo Ambiental a escala en el Amazonas y utilización por primera vez de drones en Sudamérica para estudios ambientales en un proyecto a escala.",
          id:8,
          lado:'right'
        },
        {
          title:"2015",
          img:["assets/img/about-us/paris-2015.jpg"],
          text:"COP 21 y Acuerdo de Paris. El Acuerdo incluye compromisos de todos los países para reducir sus emisiones y colaborar juntos a fin de adaptarse a los impactos del cambio climático, así como llamamientos a estos países para que aumenten sus compromisos con el tiempo.",
          id:9,
          lado:'left'
        },
        {
          title:"2018",
          img:["assets/img/about-us/brief/webp/Imagen13.jpg","assets/img/about-us/brief/webp/Imagen14.jpg","assets/img/about-us/brief/webp/Imagen15.jpg"],
          text:"Estudios diversos mediante sensores remotos de crecimiento de superficies cultivadas, erosión, disponibilidad de agua e impacto climático.",
          id:10,
          lado:'right'
        },
        {
          title:"2022",
          img:["assets/img/about-us/fewsus.jpg"],
          text:"Primer Simposio de FEWSUS en el Cono Sur (Argentina) \"SISTEMAS CIRCULARES DE BIOECONOMÍA PARA LA COPROSPERIDAD URBANO-RURAL\".",
          id:11,
          lado:'left'
        },
        {
          title:"2022",
          img:["assets/img/about-us/brief/webp/imagen17.webp","assets/img/about-us/brief/webp/Imagen18.webp","assets/img/about-us/brief/webp/Imagen19.webp"],
          text:"Participación activa en el Comité Organizador del 2022 FEWSUS Anual Symposium.",
          id:12,
          lado:'right'
        },
        {
          title:"2023",
          img:["assets/img/about-us/2023-logo.jpg"],
          text:"Fundación de Byontek.",
          id:13,
          lado:'right'
        },
        {
          title:"2023",
          img:["assets/img/about-us/carbon-forum.jpg"],
          text:"Primer ARGENTINA CARBON FORUM con el objetivo de difundir el mercado de carbono, unir interesados, evaluar la  estrategia y los lineamientos en que el sector público está trabajando con respecto a los mercados de carbono.",
          id:14,
          lado:'left'
        },
        {
          title:"2023",
          img:["assets/img/about-us/brief/webp/Imagen20.jpg"],
          text:"Participacion activa en la primer edición del  Argentina Carbon Forum.",
          id:15,
          lado:'right'
        },
        {
          title:"2023",
          img:["assets/img/about-us/aapresid2.webp"],
          text:"31º Congreso de Aapresid \"C\", elemento de vida.",
          id:16,
          lado:'left'
        },
        {
          title:"2023",
          img:["assets/img/about-us/foto4.webp"],
          text:"Participamos activamente en el 31º Congreso de Aapresid presentando al Dr. Bruno Basso de la Michigan State University (MSU - USA)  y a Investigadores de la Universidad de Tennessee (UTK - USA) como oradores en distintas temáticas.",
          id:17,
          lado:'right'
        }
      ],
      Contacto:{
        titulo:'Contacto',
        p1:'Byontek se compromete a proteger y respetar su privacidad, y solo usaremos su información personal para administrar su cuenta y proporcionar los productos y servicios que nos solicitó.',
        p2:'De vez en cuando, nos gustaría ponernos en contacto con usted acerca de nuestros productos y servicios, así como de otros contenidos que puedan ser de su interés. Si consiente que lo contactemos con este propósito, por favor marque a continuación cómo le gustaría que nos pongamos en contacto con usted:',
        p3:'Puede darse de baja de estas comunicaciones en cualquier momento.',
        p4:'Al hacer clic en enviar a continuación, usted consiente que Byontek almacene y procese la información personal enviada arriba para proporcionarle el contenido solicitado.',
        acuerdo:'Estoy de acuerdo en recibir otras comunicaciones de Byontek.',
        nombre:'Nombre',
        apellido: 'Apellido',
        email:'Email',
        celular:'Celular',
        company: 'Nombre de la Compañia',
        puesto: 'Puesto de Trabajo',
        industria:'Industria',
        mensaje: 'Mensaje',
        boton:'Enviar mensaje',
        errores:'Este dato es requerido',
        placeholder:'Ingrese su ',
        corto:'Demasiado corto para ser válido',
        emailerror:'No parece ser un email',
        emailmandado:'Email enviado correctamemte<br/>Nos contactaremos a la brevedad.',
        emailnomandado:'No hemos podido enviar el email, intente más tarde.',
        opciones:[
         
          "Insumos agrícolas",
          "Comerciante agrícola",
          "Institución bancaria",
          "Asesores de carbono / Desarrolladores de programas",
          "Consumidor / Alimentos",
          "Cooperativas / Agrónomos",
          "Etanol / Biocombustibles",
          "Proveedor de seguros",
          "Inversión en tierras / Fideicomiso de inversión inmobiliaria",
          "Carne / Lácteos / Alimentación / Ingredientes",
          "Sector público",
          "Otro"
        ]
      },
    }
  ]; 


  

  cambiarIdioma(){
    if(this.idiomaActual==='EN'){
      this.idiomaActual = 'ES';
      this.idiomaActualReves = 'EN';
      this.textos = this.home;
    }else{
      this.idiomaActual = 'EN';
      this.idiomaActualReves = 'ES';
      this.textos = this.inicio;
    }
  }

  getIdiomaActual(){
    return this.idiomaActualReves;
  }

  constructor() {
    this.textos = this.inicio;
    
    /*afterNextRender(() => {
      localStorage.setItem('idioma', JSON.stringify(this.idiomaActualReves));

      
    });*/

   }
}
