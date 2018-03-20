<?php
//// src/AppBundle/Command/CheckNotificationsCommand.php
//namespace AppBundle\Command;
//
//use AppBundle\Repository\UserProductRepository;
//use Doctrine\ORM\EntityManager;
//use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
//use Symfony\Component\Console\Command\Command;
//use Symfony\Component\Console\Input\InputInterface;
//use Symfony\Component\Console\Output\OutputInterface;
//
////class CheckNotificationsCommand extends Command
//class CheckNotificationsCommand extends ContainerAwareCommand
//{
//    protected function configure()
//    {
//        $this
//            ->setName('app:check-notifications')
//            ->setDescription('Check the notifications.')
//            ->setHelp('This command allows you to call api to check notifications...');
//    }
//
//    protected function execute(InputInterface $input, OutputInterface $output)
//    {
//        $checkNotifications = $this->getContainer()->get('app.notification_controller');
////        $checkNotifications->hello();
//
////        $checkNotifications->checkNotifications();
//
//        $em = $this->getDoctrine()->getEntityManager();
//        $userProduct = new UserProductRepository($em);
//
//        $output->writeln($checkNotifications->hello($userProduct));
////        $output->writeln($checkNotifications->checkNotifications());
//        // outputs multiple lines to the console (adding "\n" at the end of each line)
//        $output->writeln([
//            '=============================================',
//            '============ Check Notifications ============',
//            '=============================================',
//
//        ]);
//
//    }
//}